<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateNovaBlogPostsTable extends Migration
{
    protected $postsTable;

    public function __construct()
    {
        $this->postsTable = config('nova-blog.blog_posts_table', 'nova_blog_posts');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create posts table
        Schema::create($this->postsTable, function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->default('')->unique();
            $table->longText('post_introduction')->nullable();
            $table->longText('post_content')->nullable();
            $table->timestamp('published_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_image')->nullable();
            $table->string('featured_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->string('locale')->default(config('nova-blog.locales')[0] ?? 'en');
            $table->string('author')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->postsTable);
    }
}
