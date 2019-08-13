<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleProduct extends Model
{
    public $timestamps = false;

    protected $fillable = ['article_id', 'product_id'];
    public $table = "article_product";

    public function articles() {
        return $this->hasOne(Article::class, 'id', 'article_id');
    }

    public function products() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
