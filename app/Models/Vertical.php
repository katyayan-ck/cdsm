<?php

namespace App\Models;

class Vertical extends BaseModel
{
    protected $fillable = ['name', 'slug', 'status'];

    public function users()
    {
        return $this->hasMany(User::class);
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
