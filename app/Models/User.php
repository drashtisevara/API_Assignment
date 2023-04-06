<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HasPermissionsTrait;
use App\Models\Module;
use App\Models\Permission_Module;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;




class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

//     public function roles()
// {
//     return $this->belongsToMany(Role::class, 'user_role');
// }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'user_role','user_id','role_id');
    }
    public function hasPermission($module, $access)
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($module, $access)) {
                return true;
            }
        }
        return false;
    }
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function userHasPermission($module, $access, $permission)
    {
        return $this->roles()->whereHas('permission', function ($query) use ($permission) {
            $query->where('name', $permission);
        })->exists();
    }
    public function hasAccess($jobType, $access)
    {
        foreach ($this->roles as $role) {
            if ($role->hasAccess($jobType, $access)) {
                return true;
            }
        }
    }

//     protected static function boot()
// {
//     parent::boot();

//     static::created(function ($user) {
//         Mail::to($user->email)->send(new WelcomeMail());
//     });
// }

}