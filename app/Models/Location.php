<?php

namespace App\Models;

class Location extends BaseModel
{
    protected $fillable = ['branch_id', 'name', 'slug', 'status'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
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
