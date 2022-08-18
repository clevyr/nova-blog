<?php

namespace Clevyr\NovaBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Spatie\Feed\FeedItem;
use Spatie\Feed\Feedable;

class Post extends Model implements Feedable
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

    /*
     * Get a post's FeedItem
     */
    public function toFeedItem(): FeedItem
    {
        $featuredImage = '';
        $summary = $this->post_content;
        if ($this->featured_image) {
            $featuredImage = Storage::url($this->featured_image);
            if (config('filesystems.default') === 'public') {
                $featuredImage = config('app.url') . $featuredImage;
            }
            $summary = "<p><img src=\"$featuredImage\"></p>$summary";
        }

        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($summary)
            ->updated($this->updated_at)
            ->link(config('nova-blog.base_uri', '/blog') . '/post/' . $this->slug)
            ->image($featuredImage)
            ->authorName($this->author)
            ->category(...$this->post_categories->map(function ($category) {
                return $category->name;
            }));
    }

    /*
     * Get items to list in the feed
     */
    public static function getFeedItems()
    {
        return self::where('is_published', 1)->whereDate('published_at', '<=', Carbon::now())->get();
    }
}
