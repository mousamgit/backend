<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Api\V1\SuperController;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class RoleController  extends SuperController
{

    public $whichModel;
    public $responseResource;

    public function __construct()
    {
        $this->whichModel = app('App\Models\Role');
        $this->responseResource = RoleResource::class;
        parent::__construct($this->whichModel, $this->responseResource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
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
    public function update(RoleRequest $request, $id)
    {
        return parent::updateFunction($request, $id);
    }
}
