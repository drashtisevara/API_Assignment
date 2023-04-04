<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasPermissionsTrait;
use App\Models\Module;
use App\Models\Permissionmodel;
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
        return $this->hasMany(Permisionmodel::class);
    }
    
  
    
    public function modules()
    {

        return $this->belongsToMany(Module::class,'permisionmodels', 'module_id', 'permission_id')->withPivot(['module_id' ,'permission_id' ,'add_access' ,'view_access', 'edit_access', 'delete_access']);
}





public function roles()
{
    return $this->belongsToMany(Role::class, 'role_permission', 'permission_id', 'role_id');
}

public function hasAccess($jobType, $access)
    {
        
        foreach ($this->modules as $module) {
            $permisionmodel = $module->where('name', $jobType)->first();
            $getPivot = $module->pivot->where('id',$permisionmodel->id)->where($access,true)->first();
            if ($permisionmodel&& $getPivot) {
                return true;
            }
        }
        return false;
    }

}