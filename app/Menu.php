<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['menu', 'sortpriority'];

    public $timestamps = false;

    public function category() {
        return $this->hasMany(Category::class);
    }

    public function getParentCategoriesAttribute() {
        return $this->category->where('category_id', '0');
    }
}
