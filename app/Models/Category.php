<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $fillable=['name','description'];

     ///////////    Relations    ////////////

     public function subcategories(){
        return $this->hasMany(Subcategory::class,'category_id','id');
    }

    public function users(){
        return $this->belongsToMany(User::class,'user_categories','category_id','user_id');
    }
}
