<?php

namespace Clevyr\NovaBlog\Nova;

use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Panel;
use Eminiarts\Tabs\Tabs;
use Spatie\TagsField\Tags;
use App\Nova\Resource;
use Carbon\Carbon;

class BlogPost extends Resource
{

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Clevyr\NovaBlog\Models\Post::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title', 'post_content', 'post_introduction', 'slug'
    ];


    function __construct($resource)
    {
        parent::__construct($resource);
        self::$model = config('nova-blog.post_model');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        /**
         * Details panel
         */
        $panels[] = new Panel('Details', [
            ID::make(__('ID'), 'id')
                ->sortable()
                ->exceptOnForms(),
            Text::make('Title', 'title'),
            Textarea::make('Post Snippet', 'post_introduction'),
            Text::make('Author', 'author')
                ->hideFromIndex(),
            Select::make('Locale')
                ->options(config('nova-blog.locales'))
                ->default(array_key_first(config('nova-blog.locales'))),
            Boolean::make('Feature Post?', 'is_featured')
                ->default(false),
            Boolean::make('Publish Post?', 'is_published')
                ->default(false),
            DateTime::make('Published at', 'published_at')
                ->rules('required')
                ->sortable()
                ->default(Carbon::now()),
            Slug::make('Slug')
                ->from('Title')
                ->rules('required')
                ->separator('-')
                ->required()
                ->hideWhenUpdating(),
        ]);

        /**
         * Post Content
         */
        $panels[] = new Panel('Content', [
            NovaTinyMCE::make('Content', 'post_content')
                ->hideFromIndex(),
            File::make('Featured Image or Video', 'featured_image')
                ->disk(config('filesystems.default'))
                ->nullable(),
            Tags::make('Categories')
                ->withMeta(['placeholder' => 'Add categories...'])
                ->hideFromIndex()
                ->type('post_categories'),
            Tags::make('Tags')
                ->withMeta(['placeholder' => 'Add tags...'])
                ->hideFromIndex()
                ->type('post_tags'),
        ]);

        /**
         * Post SEO Meta Info
         */
        $panels[] = new Panel('SEO', [
            Text::make('SEO Title', 'seo_title')
                ->hideFromIndex()
                ->nullable(),
            Text::make('SEO Description', 'seo_description')
                ->hideFromIndex()
                ->nullable(),
            Image::make('SEO Image', 'seo_image')
                ->hideFromIndex()
                ->disk(config('filesystems.default'))
                ->nullable(),
        ]);

        return [ (new Tabs('Blog Post', $panels))->withToolbar() ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
