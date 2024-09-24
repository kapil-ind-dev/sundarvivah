<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HighestEducation extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_highest_education';
    protected $fillable = ['id','title','deleted_at','created_at','updated_at'];
    protected $dateFormat = 'Y-m-d H:i:s'; 
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
