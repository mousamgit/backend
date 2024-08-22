<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $roles = $this->roles;
        return [
            'id'=> $this->id,
            'name'=> $this->name,
            'email'=> $this->email,
            'roleParsed' => RoleResource::collection($roles),
            'permissions' => PermissionResource::collection($this->getAllPermissions()),
        ];
    }
}
