<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryCategoryModel extends Model
{
    use HasFactory;
    public $table = "tbl_secondarycategory" ;

    function tertiarycategorys()
    {
       return $this->hasMany('App\Models\TertiaryCategoryModel', 'secondary_category_id', 'id')->where('status', 1) ;
    }
}
