<?php

namespace App\Models;

use App\Models\Traits\CRUD;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory, CRUD;
    const PERMISSIONSLUG = 'permissions';

    protected $fillable = [
        'name',
        'guard_name',
        'group'
    ];

    public function scopeQueryfilter($query, $searchquery)
    {
        if ($searchquery != 'null') {
            return $query->where(function ($qq) use ($searchquery) {
                $qq->where('name', 'like', '%' . $searchquery . '%');
            });
        }
    }
}
