<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Category extends Model implements TranslatableContract
{
    use Translatable;
    use HasFactory;
    use HasEagerLimit;

    public $translatedAttributes = ['title', 'content'];
    protected $fillable = ['id', 'image', 'parent', 'created_at', 'updated_at', 'deleted_at'];   


    public function parents(){
        return $this->belongsTo(Category::class,'parent');
    }

    public function children(){
        return $this->hasMany(Category::class,'parent');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}
