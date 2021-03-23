<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'Users';
    public $timestamps = false;
    protected $primaryKey = 'UserID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'FirstName', 'LastName', 'email', 'password', 'PhoneNumber', 'RoleID', 'JobID'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'Remember_token',

    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function sites()
    {
        return $this->hasMany(Site::class, 'OwnerID');
    }

    public function role()
    {
        return $this->hasMany(Role::class);
    }

    public function jobs()
    {
        return $this->belongsTo(User::class, 'JobID');
    }

    public function assignment()
    {
        return $this->hasMany(SiteApproval::class,'UserID');
    }
}
