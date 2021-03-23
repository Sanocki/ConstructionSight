<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteApproval extends Model
{
    protected $table = 'tbl_SiteApproval';
    public $timestamps = false;
    protected $primaryKey = 'ApprovalID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'UserID', 'SiteID', 'Status', 'Date'
    ];

    // Many to many relationship between tables (tbl_Users)
    public function users()
    {
        return $this->belongsTo(User::class,'UserID');
    }

    // Many to many relationship between tables (tbl_Users)
    public function sites()
    {
        return $this->belongsTo(Site::class,'SiteID');
    }

    public function siteLots()
    {
        return $this->hasMany(Lot::class,'SiteID');
    }
}