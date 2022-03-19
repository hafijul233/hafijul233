<?php

namespace App\Models\Backend\Organization\Enumerator;

use App\Models\Backend\Organization\Enumerator;
use App\Models\Backend\Setting\Catalog;
use App\Models\Backend\Setting\ExamGroup;
use App\Models\Backend\Setting\ExamLevel;
use App\Models\Backend\Setting\ExamTitle;
use App\Models\Backend\Setting\Institute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class EducationQualification extends Model implements Auditable
{
    use AuditableTrait, HasFactory, SoftDeletes, Sortable;

    /**
     * @var string $table
     */
    protected $table = 'education_qualifications';

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
    protected $fillable = [ 'enumerator_id', 'exam_level_id', 'exam_title_id', 'exam_board_id', 'institute_id', 'pass_year', 'roll_number', 'grade_type', 'grade_point', 'enabled'];


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

    /************************ Audit Relations ************************/

    /**
     * @return BelongsTo
     */
    public function enumerator()
    {
        return $this->belongsTo(Enumerator::class);
    }

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

    /**
     * @return BelongsTo
     */
    public function examGroup()
    {
        return $this->belongsTo(ExamGroup::class);
    }

    /**
     * @return BelongsTo
     */
    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

    /**
     * @return BelongsTo
     */
    public function examBoard()
    {
        return $this->belongsTo(Catalog::class, 'exam_board_id', 'id');
    }

}
