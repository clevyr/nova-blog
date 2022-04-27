<?php

return [
    /*
     * The database table name where posts should be stored
     * type: String
     */
    'blog_posts_table' => 'nova_blog_posts',

    /*
     * The Eloquent model for the posts
     * type: Eloquent Model
     */
    'post_model' => \Clevyr\NovaBlog\Models\Post::class,

    /*
     * The Nova Resource file for the posts
     * type: Nova Resource Model
     */
    'nova_resource' => \Clevyr\NovaBlog\Nova\BlogPost::class,

    /*
     * The base URI for blogs.
     * ex: /blog
     * type: String
     *
     * Maintain leading slash
     */
    'base_uri' => '/blog',

    /*
     * The base URI for blogs posts.
     * ex: /post
     * type String
     *
     * Maintain leading slash
     */
    'post_base_uri' => '/post',

    /*
     * An array of locales with a key => value of 'locale_slug' => 'locale display string'
     */
    'locales' => [
        'en' => 'English',
    ],
];
