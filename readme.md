# Clevyr Nova Blog Resource

#### Features
1. Title
2. Author
3. Snippet
4. Locales
5. Customizable slug
6. Featured posts
7. Customizable published-at dates 
8. "Published" or "draft" status
9. RTE content (TinyMCE)
10. Featured image for posts
11. Categories
12. Tags (separate from Categories)
13. Custom SEO information (title, description and image)


#### Requirements
Vue 3  
Laravel 8+  
Nova 3.0+  

## Installation
Install the package
```
composer require clevyr/nova-blog-package
```

## Config
#### Blog Post Settings
```
nova-blog.php
```
| Option    | Description                                                                        | Accepted Values         | 
|------------------|------------------------------------------------------------------------------------|-------------------------|
| blog_posts_table | The database table name where posts should be stored                               | String                  |
| post_model       | The Eloquent model for the posts                                                   | Eloquent Model Class    |
| nova_resource    | The Nova Resource file for the posts                                               | Nova Resource Class     |
| base_uri         | The base URI for blogs. ex: website.com`/blog`                                     | String with leading `/` |
| post_uri         | The base URI for blogs posts. ex: website.com/blog`/post`/post-slug                | String with leading `/` |
| locales          | An array of locales with a key => value of 'locale_slug' => 'locale display string' | Array                   |
#### Tag & Category Settings
```
tags.php
```
Reference 3rd party package - [https://github.com/spatie/nova-tags-field](https://github.com/spatie/nova-tags-field)

## Accessing Data 
### Via Routes
#### Fetch all published posts
Route: `$base_uri/get-published-posts`  
Example: `/blog/get-published-posts`  
Returns: JSON of all published blog posts
#### Fetch individual post
Route: `$base_uri/$post_uri/{post_slug}`  
Example: `/blog/post/my-blog-post`  
Returns: Eloquent object of Post model

## Setting Default Images
To set default images for posts, featured images or seo images, you can create a new migration to change the default 
value.
```
Schema::table(config('nova-blog.blog_posts_table'), function (Blueprint $table) {
    $table->string('featured_image')->default('/path-to-image')->change();
});
```
