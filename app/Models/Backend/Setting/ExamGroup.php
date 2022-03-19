<?php

namespace App\Models\Backend\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @class ExamGroup
 * @package App\Models\Backend\Setting
 */
class ExamGroup extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, HasFactory, SoftDeletes, Sortable;

    /**
     * @var string $table
     */
    protected $table = 'exam_groups';

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
    protected $fillable = [ 'name', 'remarks', 'enabled', 'exam_level_id', 'exam_title_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * @return BelongsTo
     */
    public function examLevel()
    {
        return $this->belongsTo(ExamLevel::class);
    }

    /**
     * @return BelongsTo
     */
    public function examTitle()
    {
        return $this->belongsTo(ExamTitle::class);
    }

}
