<?php

// Home
Breadcrumbs::for('index', function ($trail) {
    $trail->push('Главная', route('index'));
});

// Home > About
// Breadcrumbs::for('about', function ($trail) {
//     $trail->parent('home');
//     $trail->push('About', route('about'));
// });

// // Home > Blog
// Breadcrumbs::for('blog', function ($trail) {
//     $trail->parent('home');
//     $trail->push('Blog', route('blog'));
// });

// Home > Category > [Product]
Breadcrumbs::for('categories', function ($trail) {
    $trail->parent('index');
    $trail->push('Категории товаров', route('categories'));
});

Breadcrumbs::for('category', function ($trail, $category) {
    // dd($category);
    $trail->parent('categories');
    $trail->push($category->category, route('category', $category->slug));
});

// Breadcrumbs::for('product', function ($trail, $category, $product) {
//     // dd($trail);
//     $trail->parent('category', $product->category);
//     $trail->push($product->product, route('product', $product->category->slug, $product->slug));
// });

// Home > Blog > [Category] > [Post]
// Breadcrumbs::for('post', function ($trail, $post) {
//     $trail->parent('category', $post->category);
//     $trail->push($post->title, route('post', $post->id));
// });