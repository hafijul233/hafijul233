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
class Certificate extends Model implements Auditable, HasMedia
{
    use AuditableTrait;
    use HasFactory;
    use SoftDeletes;
    use Sortable;
    use InteractsWithMedia;

    /**
     * @var string $table
     */
    protected $table = 'certificates';

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     * 'enabled' => to handle status
     *
     * @var array
     */
    protected $fillable = ['name', 'organization', 'issue_date', 'expire_date', 'credential', 'verify_url', 'description', 'enabled'];

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
        'issue_date' => 'date',
        'expire_date' => 'date',

    ];

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
        $this->addMediaCollection('certificates')
            ->useDisk('certificate')
            ->useFallbackUrl(asset(Constant::SERVICE_IMAGE))
            ->acceptsMimeTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg'])
            ->singleFile();
    }
}
