# Clevyr Nova Blog Resource

#### Features
1. Title
2. Author
3. Customizable slug
4. Published at date 
5. Published or Draft status
6. RTE content (TinyMCE)
7. Featured Image
8. Categories
9. Tags (separate from Categories)
10. Custom SEO information


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
| nova_resource    | The Nova Resource file for the posts                                               | Eloquent Model Class    |
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

