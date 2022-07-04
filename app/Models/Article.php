<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Models\Users\User;
use App\Services\Database\Eloquent\BaseModel;
use Database\Factories\ArticleFactory;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\HtmlString;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class Article extends BaseModel
{
    use HasSlug;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';

    protected $fillable = [
        'slug',
        'title',
        'excerpt',
        'body',
        'published',
        'user_id',
    ];

    /**
     * The attributes that should be casted.
     *
     * @var array
     */
    protected $casts = [
        'published' => 'boolean',
    ];

    protected static function newFactory()
    {
        return ArticleFactory::new();
    }


    /**
     * The post author.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the renderable post content.
     *
     * @return HtmlString
     */
    public function getContentAttribute()
    {
        $converter = new GithubFlavoredMarkdownConverter([
            'allow_unsafe_links' => false,
        ]);

        return new HtmlString($converter->convert($this->body));
    }

    /**
     * Scope a query to only include published posts.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    /**
     * Scope a query to only include drafts (unpublished posts).
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeDraft($query)
    {
        return $query->where('published', false);
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param \DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
