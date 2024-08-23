<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\AccessDeniedException;
use App\Exports\CommonExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class SuperController extends Controller
{
    public $whichModel;
    public $responseResource;


    public function __construct($whichModel, $responseResource)
    {
        $this->whichModel = $whichModel;
        $this->responseResource = $responseResource;
    }


    public function index(Request $request)
    {
        $authUser = $request->user();
        if ($this->constant_exists($this->whichModel, 'PERMISSIONSLUG')) {
            $permissionSlug = $this->whichModel::PERMISSIONSLUG;
            if (!$authUser->can('view-' . $permissionSlug)) {
                throw new AccessDeniedException('unauthorized_access');
            }
        }

        $rowsPerPage = $request->get('rowsPerPage') ? $request->get('rowsPerPage') : 10;
        $model = $this->whichModel::initializer();
        $rowsPerPage = $request->get('rowsPerPage') == 0 ? $model->count() : $rowsPerPage;
        $model = $model->paginate($rowsPerPage);

        return $this->responseResource::collection($model)
            ->response()
            ->setStatusCode(200);
    }


    public function constant_exists($class, $name)
    {
        if (is_object($class) || is_string($class)) {
            $reflect = new \ReflectionClass($class);
            return array_key_exists($name, $reflect->getConstants());
        }
        return FALSE;
    }


    public function all()
    {
        $authUser = Auth::user();
        $all = $this->whichModel::initializer()->get();

        return $this->responseResource::collection($all)
            ->response()
            ->setStatusCode(200);
    }


    public function export(Request $request, $headers = NULL, $mapping = NULL)
    {
        $authUser = Auth::user();
        $permissionSlug = $this->whichModel::PERMISSIONSLUG;
        if (!$authUser->can('export-' . $permissionSlug)) {
            throw new AccessDeniedException('unauthorized_access');
        }
        $rowsPerPage = $request->get('rowsPerPage') ? $request->get('rowsPerPage') : 10;
        $model = $this->whichModel::initializer();
        $rowsPerPage = $request->get('rowsPerPage') == 0 ? $model->count() : $rowsPerPage;
        $model = $model->paginate($rowsPerPage);

        if (!isset($headers))
            $headers = $this->whichModel::EXPORTHEADERS;

        if (!isset($mapping))
            $mapping = $this->whichModel::EXPORTMAPPINGS();

        $exportClass = new CommonExport($model, $headers, $mapping);
        // generic solution
        $reflection = new \ReflectionClass($this->whichModel);

        if ($request->has('exportName')) {
            $exportName = $request->get('exportName') . time() . '.xlsx';
        } else {
            $exportName = Str::slug($reflection->getShortName()) . time() . '.xlsx';
        }
        $path = 'export/' . $exportName;
        $export = Excel::store($exportClass, $path, 'minio');
        $expiry = Carbon::today()->addDays(7);

        if ($export) {
            return Response::json([
                'code' => 200,
                'url' => Storage::cloud()->temporaryUrl($path, $expiry),
                'message' => 'Success',
            ], 200);
        } else {
            return Response::json([
                'code' => 500,
                'message' => 'Something went wrong',
            ], 500);
        }
    }


    public function storeFunction(Request $request)
    {
        $authUser = Auth::user();
        $permissionSlug = $this->whichModel::PERMISSIONSLUG;
        if (!$authUser->can('create-' . $permissionSlug)) {
            throw new AccessDeniedException('unauthorized_access');
        }
        DB::beginTransaction();
        try {
            $model = $this->createFunction($request);
            if (method_exists(new $this->whichModel(), 'afterCreateProcess')) {
                $model->afterCreateProcess();
            }
            DB::commit();
            if ($model instanceof $this->whichModel) {
                return (new $this->responseResource($model))->response()->setStatusCode(200);


            } else {
                return Response::json([
                    'code' => 400,
                    'message' => $model,
                ], 400);
            }
        } catch (\Exception $e) {
            DB::rollBack();
dd($e);
            return Response::json([
                'code' => 500,
                'message' => 'Something went wrong',
            ], 500);
        }
    }


    public function createFunction(Request $request)
    {
        return $this->whichModel::create($request->only($this->getAllFieldNames()));
    }


    public function getAllFieldNames()
    {
        $fillableFields = (new $this->whichModel())->getFillable();

        return $fillableFields;
    }


    public function updateFunction(Request $request, $id)
    {
        $authUser = Auth::user();
        $permissionSlug = $this->whichModel::PERMISSIONSLUG;
        if (!$authUser->can('update-' . $permissionSlug)) {
            throw new AccessDeniedException('unauthorized_access');
        }
        DB::beginTransaction();
        try {
            $model = $this->updateModelFunction($request, $id);
            if (method_exists(new $this->whichModel(), 'afterUpdateProcess')) {
                $model->afterUpdateProcess();
            }
            DB::commit();

            return (new $this->responseResource($model))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            DB::rollBack();
            abort(500, $e);
        }
    }


    public function updateModelFunction(Request $request, $id)
    {
        $model = $this->whichModel::findOrFail($id);
        $model->update($request->only($this->getAllFieldNames()));

        return $model;
    }


    public function delete(Request $request)
    {
        $authUser = Auth::user();

        $permissionSlug = $this->whichModel::PERMISSIONSLUG;
        if (!$authUser->can('delete-' . $permissionSlug)) {
            throw new AccessDeniedException('unauthorized_access');
        }
        $itemsToDelete = $request->get('delete_rows');
        foreach ($itemsToDelete as $item) {
            $model = $this->whichModel::initializer();
            $model = $model->find($item);
            if ($model) {
                $model->delete();
            }
        }

        return Response::json([
            'code' => 200,
            'message' => 'Success',
        ], 200);
    }
//
//    public function getAllFieldNames()
//    {
//        return (new $this->whichModel())->getFillable();
//            'message' => 'Success',
//        ], 200);
//    }
}
