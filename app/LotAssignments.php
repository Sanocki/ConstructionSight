<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LotAssignments extends Model
{
    protected $table = 'tbl_LotAssignment';
    public $timestamps = false;
    protected $primaryKey = 'AssignmentID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'JobID', 'LotID', 'UserID', 'Occupying', 'DateAssigned', 'TimeOcccupied'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'UserID');
    }

    public function lot()
    {
        return $this->belongsTo(Lot::class,'LotID');
    }

    public function jobs()
    {
        return $this->belongsTo(Job::class,'JobID');
    }
}
