<?php

namespace App\Models\Backend\Organization;

use App\Models\Backend\Organization\Enumerator\EducationQualification;
use App\Models\Backend\Organization\Enumerator\WorkQualification;
use App\Models\Backend\Setting\Catalog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @class Enumerator
 * @package App\Models\Backend\Organization
 */
class Enumerator extends Model implements Auditable
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
    protected $fillable = ['survey_id','gender_id', 'name', 'name_bd', 'father', 'father_bd',
        'mother', 'mother_bd', 'nid', 'mobile_1', 'mobile_2', 'email',
        'present_address', 'present_address_bd', 'permanent_address',
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
        return $this->belongsToMany(Survey::class);
    }

    public function educationQualifications()
    {
        return $this->hasMany(EducationQualification::class);
    }

    public function workQualifications()
    {
        return $this->hasMany(WorkQualification::class);
    }

    public function gender()
    {
        return $this->belongsTo(Catalog::class, 'gender_id', 'id');
    }

}
