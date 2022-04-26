<?php

return [
    'blog_posts_table' => 'nova_blog_posts',

    'post_model' => \Clevyr\NovaBlog\Models\Post::class,

    'nova_resource' => \Clevyr\NovaBlog\Nova\BlogPost::class,

    'locales' => [
        'en' => 'English',
    ],
];
