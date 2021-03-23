<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'lk_Roles';
    public $timestamps = false;
    protected $primaryKey = 'RoleID';

    const COMPANY = 1;
    const MANAGER = 2;
    const SUPERVISOR = 3;
    const CONTRACTOR = 4;
}
