<?php

namespace App\Models\Backend\Resume;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @class Post
 * @package App\Models\Backend\Resume
 */
class Award extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SoftDeletes;
    use Sortable;

    /**
     * @var string $table
     */
    protected $table = 'awards';

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
    protected $fillable = ['title', 'associate', 'issuer', 'issue_date', 'description', 'enabled'];

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
        'issue_date' => 'date'
    ];

    /**
     * The model's default values for attributes when new instance created.
     *
     * @var array
     */
    protected $attributes = [
        'enabled' => 'yes'
    ];

    /************************ Audit Relations ************************/

    public function enumerators()
    {
        return $this->hasMany(Post::class);
    }
}
