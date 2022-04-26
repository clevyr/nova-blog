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
}
