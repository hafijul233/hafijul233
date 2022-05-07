<?php

namespace App\Models\Backend\Portfolio;

use App\Models\Backend\Portfolio\Enumerator\EducationQualification;
use App\Models\Backend\Portfolio\Enumerator\WorkQualification;
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
 * @class Post
 * @package App\Models\Backend\Portfolio
 */
class Certificate extends Model implements Auditable
{
    use AuditableTrait, HasFactory, SoftDeletes, Sortable;

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
     * 'enabled' => to handle status,
     * ['created_by', 'updated_by', 'deleted_by'] => for audit
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

    public function surveys()
    {
        return $this->belongsToMany(Comment::class);
    }

    public function educationQualifications()
    {
        return $this->hasMany(EducationQualification::class);
    }

    public function workQualifications()
    {
        return $this->hasMany(WorkQualification::class);
    }

    public function examLevel()
    {
        return $this->belongsTo(ExamLevel::class, 'exam_level', 'id');
    }


    public function gender()
    {
        return $this->belongsTo(Catalog::class, 'gender_id', 'id');
    }

    public function previousPostings()
    {
        return $this->belongsToMany(State::class, 'enumerator_previous_state');
    }

    public function futurePostings()
    {
        return $this->belongsToMany(State::class, 'enumerator_future_state');
    }

}
