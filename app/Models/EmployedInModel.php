<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployedInModel extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_employedin';
    protected $fillable = ['id','title','deleted_at','created_at','updated_at'];
    protected $dateFormat = 'Y-m-d H:i:s'; 
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    // public function profession()
    // {
    //     return $this->belongsTo(ProfessionModel::class, 'empin_id'); // Ensure 'empin_id' matches the foreign key
    // }
}
