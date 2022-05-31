<?php

namespace App\Models\Backend\Blog;

use App\Models\Backend\Setting\Catalog;
use App\Models\Backend\Setting\ExamLevel;
use App\Models\Backend\Setting\State;
use App\Supports\Constant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class Post
 * @package App\Models\Backend\Blog
 */
class Post extends Model implements Auditable,HasMedia
{
    use AuditableTrait;
    use HasFactory;
    use SoftDeletes;
    use Sortable;
    use InteractsWithMedia;

    /**
     * @var string $table
     */
    protected $table = 'posts';

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     * 'enabled' => to handle status,
     * ['created_by', 'updated_by', 'deleted_by'] => for audit
     *
     * @var array
     */
    protected $fillable = ['title', 'summary', 'content', 'category_id', 'published_at', 'enabled'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime'
    ];

    /**
     * The model's default values for attributes when new instance created.
     *
     * @var array
     */
    protected $attributes = [
        'enabled' => 'no',
        'published_at' => null
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::boot();

        static::retrieved(function ($post) {
            $post->slug = Str::slug($post->title);
        });
    }

    /**
     * Register Cover Image Media Collection
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('posts')
            ->useDisk('post')
            ->useFallbackUrl(asset(Constant::SERVICE_IMAGE))
            ->acceptsMimeTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg'])
            ->singleFile();
    }
}
