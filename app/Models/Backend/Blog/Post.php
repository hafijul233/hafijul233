<?php

namespace App\Models\Backend\Blog;

use App\Models\Backend\Blog\Enumerator\EducationQualification;
use App\Models\Backend\Blog\Enumerator\WorkQualification;
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
 * @package App\Models\Backend\Blog
 */
class Post extends Model implements Auditable
{
    use AuditableTrait, HasFactory, SoftDeletes, Sortable;

    /**
     * @var string $table
     */
    protected $table = 'enumerators';

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
    protected $fillable = ['survey_id', 'gender_id', 'dob', 'name', 'name_bd', 'father', 'father_bd',
        'mother', 'mother_bd', 'nid', 'mobile_1', 'mobile_2', 'email', 'is_employee', 'designation',
        'present_address', 'present_address_bd', 'permanent_address', 'company',
        'permanent_address_bd', 'gender', 'enabled', 'whatsapp', 'facebook', 'exam_level'];

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
