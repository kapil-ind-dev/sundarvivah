<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfessionModel extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_profession';
    protected $fillable = ['id', 'empin_id', 'title', 'deleted_at', 'created_at', 'updated_at'];
    protected $dateFormat = 'Y-m-d H:i:s'; 
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    // public function employedIn()
    // {
    //     return $this->hasOne(EmployedInModel::class, 'id'); // Ensure 'empin_id' matches the foreign key in EmployedInModel
    // }
}
