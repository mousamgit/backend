<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Exceptions\AccessDeniedException;
use App\Http\Controllers\Api\V1\SuperController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class UserController extends SuperController
{

    public $whichModel;
    public $responseResource;

    public function __construct()
    {
        $this->whichModel = app('App\Models\User');
        $this->responseResource = UserResource::class;
        parent::__construct($this->whichModel, $this->responseResource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        return parent::storeFunction($request);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        return parent::updateFunction($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $authUser = Auth::user();
        $permissionSlug = $this->whichModel::PERMISSIONSLUG;
        if (!$authUser->can('manage-' . $permissionSlug)) {
            throw new AccessDeniedException('unauthorized_access');
        }
        $itemsToDelete = $request->get('delete_rows');
        foreach ($itemsToDelete as $item) {
            $model = $this->whichModel::initializer();
            $model = $model->find($item);
            if ($model && $model->id != $authUser->id) {
                $model->delete();
            }
        }
        return Response::json(array(
            'code' => 200,
            'message' => 'Success'
        ), 200);
    }
}
