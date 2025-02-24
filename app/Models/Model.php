<?php

namespace App\Models;

use Spatie\MediaLibrary\InteractsWithMedia;

class Model extends BaseModel
{
    use InteractsWithMedia;

    protected $fillable = ['segment_id', 'name', 'slug', 'status'];

    public function segment()
    {
        return $this->belongsTo(Segment::class);
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
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
        $this->addMediaCollection('gallery');
        $this->addMediaCollection('specifications')->singleFile();
    }
}
