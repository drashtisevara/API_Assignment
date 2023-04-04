<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module;
use App\Models\Permissionmodel;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserRole;

class Role extends Model
{
    protected $guarded= [];
    use HasFactory;

    // public function permissions()
    // {
    //     return $this->belongsToMany(Permission::class,'role_permisions');
    // }
    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function users()
{
    return $this->belongsToMany(User::class,'user_role','user_id','role_id');
}

public function hasPermission($module, $access)
{
    foreach ($this->permissions as $permission) {
        if ($permission->module == $module && $permission->$access) {
            return true;
        }
    }

    return false;
}
public function userHasRole($role)
    {
        foreach ($this->roles as $role) {
            if ($role->userHasRole($name)) {
                return true;
            }
        }
    
        return false;
        // foreach($this->roles as $role){
        //     if($role->name == $role->name)
        //     return true;
            
        // }
        // return false;
    }

    public function hasAccess($jobType, $access)
     {
         foreach ($this->permissions as $permission) {
             if ($permission->hasAccess($jobType, $access)) {
                 return true;
             }
         }
     }
}