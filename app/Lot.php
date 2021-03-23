<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    protected $table = 'tbl_Lots';
    public $timestamps = false;
    protected $primaryKey = 'LotID';

    const NoJobs = 1;
    const Clean = 2;
    const Dirty = 3;
    const Complete = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'SiteID', 'Number', 'Status', 'CompletionDate', 'DueDate'
    ];

    public function assignments()
    {
        return $this->hasMany(LotAssignments::class,'LotID');
    }

    public function site()
    {
        return $this->belongsTo(Site::class,'SiteID');
    }

    public function status()
    {
        return $this->belongsTo(Status::class,'StatusID');
    }
}
