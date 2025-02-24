<?php

namespace App\Models;

use Spatie\MediaLibrary\InteractsWithMedia;

class Segment extends BaseModel
{
    use InteractsWithMedia;

    protected $fillable = ['name', 'slug', 'status'];

    public function models()
    {
        return $this->hasMany(Model::class);
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
        $this->addMediaCollection('icons');
    }
}
