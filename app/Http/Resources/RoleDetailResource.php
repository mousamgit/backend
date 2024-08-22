<?php

namespace App\Http\Resources;

use App\Models\Permission;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'display_name' => $this->name,
            'name' => $this->name,
            'guard_name' => $this->guard_name,
            'permissions' => PermissionResource::collection($this->permissions),
        ];
    }
}
