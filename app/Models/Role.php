<?php

namespace App\Models;

use App\Models\Traits\CRUD;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory, CRUD;
    const PERMISSIONSLUG = 'roles';
    protected $fillable = [
        'name',
        'guard_name'
        
    ];

    public function scopeQueryfilter($query, $searchquery)
    {
        if ($searchquery != 'null') {
            return $query->where(function ($qq) use ($searchquery) {
                $qq->where('name', 'like', '%' . $searchquery . '%');
            });
        }
    }

    public function afterCreateProcess()
    {
        $permissions = request()->get('permissions');
        
        $this->permissions()->sync($permissions);
    }

    public function afterUpdateProcess()
    {
        $permissions = request()->get('permissions');
        $this->permissions()->sync($permissions);
    }

    protected static function booted()
    {
        static::addGlobalScope('admin_user', function (Builder $builder) {
            $builder->with(['permissions']);
        });
    }
}
