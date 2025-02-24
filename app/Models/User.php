<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends BaseModel
{
    use HasRoles, InteractsWithMedia;

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'emp_id',
        'password',
        'designation_id',
        'department_id',
        'division_id',
        'branch_id',
        'location_id',
        'cash_disc_power',
        'status'
    ];

    protected $casts = [
        'cash_disc_power' => 'array',
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function reportings()
    {
        return $this->hasMany(UserReporting::class, 'user_id');
    }

    public function reportingTo()
    {
        return $this->hasMany(UserReporting::class, 'reporting_to_id');
    }

    public function segments()
    {
        return $this->belongsToMany(Segment::class, 'user_segments');
    }

    public function verticals()
    {
        return $this->belongsToMany(Vertical::class, 'user_verticals');
    }

    public function models()
    {
        return $this->belongsToMany(Model::class, 'user_models');
    }

    public function getStatusLabelAttribute()
    {
        $status = $this->status ?? 'unknown';
        $labels = [
            '0' => '<span class="badge badge-danger">Inactive</span>',
            '1' => '<span class="badge badge-success">Active</span>',
            '2' => '<span class="badge badge-warning">Pending</span>',
        ];
        return $labels[$status] ?? '<span class="badge badge-primary">Status: ' . $status . '</span>';
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_image')->singleFile();
    }
}
