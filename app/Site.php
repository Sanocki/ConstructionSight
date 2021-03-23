<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Lot;

class Site extends Model
{
    protected $table = 'tbl_Sites';
    public $timestamps = false;
    protected $primaryKey = 'SiteID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'OwnerID', 'Name', 'Address', 'Phone', 'Lots', 'Photo', 'Status'
    ];

    // Many to many relationship between tables (tbl_Users)
    public function siteLots()
    {
        return $this->hasMany(Lot::class,'SiteID');
    }
}
