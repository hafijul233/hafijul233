<?php

namespace App\Models\Backend\Portfolio;

use App\Supports\Constant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @class Post
 * @package App\Models\Backend\Portfolio
 */
class Service extends Model implements HasMedia, Auditable
{
    use AuditableTrait, HasFactory, SoftDeletes, Sortable, InteractsWithMedia;

    /**
     * @var string $table
     */
    protected $table = 'services';

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
    protected $fillable = ['name', 'summary', 'description', 'enabled'];

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
    protected $casts = [];

    /**
     * The model's default values for attributes when new instance created.
     *
     * @var array
     */
    protected $attributes = [
        'enabled' => 'yes'
    ];

    /**
     * Register Cover Image Media Collection
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('services')
            ->useDisk('service')
            ->useFallbackUrl(asset(Constant::SERVICE_IMAGE))
            ->acceptsMimeTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg'])
            ->singleFile();
    }
}
