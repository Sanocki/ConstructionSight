<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'lk_Jobs';
    public $timestamps = false;
    protected $primaryKey = 'JobID';

    public function jobs()
    {
        return $this->belongsTo(User::class,'JobID');
    }

    public function lotAssignment()
    {
        return $this->hasMany(LotJobs::class,'JobID');
    }
}
