<?php

namespace App\Models;

class UserReporting extends BaseModel
{
    protected $fillable = [
        'user_id',
        'reporting_to_id',
        'segment_id',
        'model_id',
        'vertical_id',
        'branch_id',
        'location_id',
        'department_id',
        'division_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reportingTo()
    {
        return $this->belongsTo(User::class, 'reporting_to_id');
    }

    public function segment()
    {
        return $this->belongsTo(Segment::class);
    }

    public function model()
    {
        return $this->belongsTo(Model::class);
    }

    public function vertical()
    {
        return $this->belongsTo(Vertical::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function getStatusLabelAttribute()
    {
        $status = $this->status ?? 'unknown';
        $labels = [
            '0' => '<span class="badge badge-danger">Inactive</span>',
            '1' => '<span class="badge badge-success">Active</span>',
        ];
        return $labels[$status] ?? '<span class="badge badge-primary">Status: ' . $status . '</span>';
    }
}
