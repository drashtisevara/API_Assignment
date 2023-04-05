<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module;
use App\Models\Permission_Module;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserRole;

class Permission_Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'delete_access',
        'edit_access',
        'add_access',
        'view_access'
    ];

    public $timestamp = false; 
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}