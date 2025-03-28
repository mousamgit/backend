<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
            'value' => $this->id,
            'name' => $this->name,
            'guard_name' => $this->guard_name,
            'group' => $this->group,
            'display_name' => $this->name,
            'label' => $this->name,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
        ];
    }
}
