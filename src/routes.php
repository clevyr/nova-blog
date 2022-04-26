<?php

use Illuminate\Support\Facades\Route;

/**
 * Return json data for a specific post by slug
 */
Route::get(config('nova-blog.post_base_uri', '/post') . '/{slug}', function($slug) {
   $model = app(config('nova-blog.post_model'));
   $post = $model->where('slug', $slug)->where('is_published', 1)->first();
   return json_encode($post);
});
