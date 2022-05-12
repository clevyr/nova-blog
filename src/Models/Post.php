<?php

namespace Clevyr\NovaBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use \Spatie\Tags\HasTags;

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'published_at',
    ];

    protected $appends = [
        'post_categories',
        'post_tags',
        'storage_path',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Set the table from the config file
        $this->setTable(config('nova-blog.blog_posts_table', 'nova_blog_posts'));
    }

    /*
        Return available locales from the config file
    */
    public function getLocales()
    {
        return [
            'locales' => config('nova-blog.locales'),
            'active' => $this->locale,
        ];
    }

    /*
        Return the post's categories
    */
    public function getPostCategoriesAttribute() {
        $tags =  $this->tags->filter(function($tag) {
            return $tag->type === 'post_categories';
        })->values();

        return $tags;
    }

    /*
        Return the post's tags
    */
    public function getPostTagsAttribute() {
        $tags = $this->tags->filter(function($tag) {
            return $tag->type === 'post_tags';
        })->values();

        return $tags;
    }

    /*
        Return all published posts, that were published during or before today
    */
    public function publishedPosts() {
        return $this->where('is_published', 1)->whereDate('published_at', '<=', Carbon::now());
    }

    /*
        Automatically append the default storages url for files
    */
    public function getStoragePathAttribute() {
        return Storage::url('/');
    }
}
