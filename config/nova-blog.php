<?php

return [
    'blog_posts_table' => 'nova_blog_posts',

    'post_model' => \Clevyr\NovaBlog\Models\Post::class,

    'nova_resource' => \Clevyr\NovaBlog\Nova\BlogPost::class,

    'post_base_uri' => '/post',

    'base_uri' => '/blog',

    'locales' => [
        'en' => 'English',
    ],
];
