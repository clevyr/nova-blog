<?php

namespace Clevyr\NovaBlog\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('nova-blog.blog_posts_table', 'nova_blog_posts'));
    }

    public function getLocales()
    {
        return [
            'locales' => config('nova-blog.locales'),
            'active' => $this->locale,
        ];
    }

    public function getPostCategoriesAttribute() {
        $tags =  $this->tags->filter(function($tag) {
            return $tag->type === 'post_categories';
        })->values();

        return $tags;
    }

    public function getPostTagsAttribute() {
        $tags = $this->tags->filter(function($tag) {
            return $tag->type === 'post_tags';
        })->values();

        return $tags;
    }
}
