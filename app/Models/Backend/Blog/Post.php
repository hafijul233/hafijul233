<?php

namespace App\Models\Backend\Blog;

use App\Models\Backend\Setting\Catalog;
use App\Models\Backend\Setting\ExamLevel;
use App\Models\Backend\Setting\State;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Post
 * @package App\Models\Backend\Blog
 */
class Post extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SoftDeletes;
    use Sortable;

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
}
