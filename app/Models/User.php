<?php

namespace App\Models;

use App\Models\Traits\CRUD;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CRUD, HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    const PERMISSIONSLUG = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeQueryfilter($query, $searchquery)
    {
        if ($searchquery != 'null') {
            return $query->where(function ($qq) use ($searchquery) {
                $qq->where('name', 'like', '%' . $searchquery . '%')
                    ->orWhere('email', 'like', '%' . $searchquery . '%');
            });
        }
    }

    protected static function booted()
    {
        static::addGlobalScope('admin_user', function (Builder $builder) {

        });
    }


    public function afterCreateProcess()
    {
        $request = request();

        $role = $request->get('role');
        $this->password = Hash::make($request->get('password'));
        $this->save();
        $role = Role::findById($role, 'user-api');
        $this->syncRoles([$role]);
    }

    public function afterUpdateProcess()
    {
        $request = request();
        $role = $request->get('role');
        $password = $request->get('password');
        if (isset($password)) {
            $this->password = Hash::make($password);
        }
        $this->save();
        $role = Role::findById($role, 'user-api');
        $this->syncRoles([$role]);
    }
}
