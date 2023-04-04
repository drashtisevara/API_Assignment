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

class Module extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description'
    ];


    public function permissions()
    {

        return $this->belongsToMany(Permission::class,'permisionmodels');
}
}