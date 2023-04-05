<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasPermissionsTrait;
use App\Models\Module;
use App\Models\Permission_Module;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserRole;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';
    protected $fillable = ['name', 'description'];
    
    public function access()
    {
        return $this->hasMany(Permission_Module::class);
    }
    
    public function modules()
    {
        return $this->belongsToMany(Module::class,'permission__modules', 'module_id', 'permission_id')->withPivot(['module_id' ,'permission_id' ,'add_access' ,'view_access', 'edit_access', 'delete_access']);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission', 'permission_id', 'role_id');
    }

    public function hasAccess($jobType, $access)
    {       
        foreach ($this->modules as $module) {
            $permissionModule = $module->where('name', $jobType)->first();
            $getPivot = $module->pivot->where('id',$permissionModule->id)->where($access,true)->first();
            if ($permissionModule&& $getPivot) {
                return true;
            }
        }
        return false;
    }

}