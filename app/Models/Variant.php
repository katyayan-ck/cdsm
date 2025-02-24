<?php

namespace App\Models;

use Spatie\MediaLibrary\InteractsWithMedia;

class Variant extends BaseModel
{
    use InteractsWithMedia;

    protected $fillable = ['model_id', 'name', 'slug', 'status'];

    public function model()
    {
        return $this->belongsTo(Model::class);
    }

    public function colors()
    {
        return $this->hasMany(Color::class);
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
        $this->addMediaCollection('image')->singleFile();
        $this->addMediaCollection('features')->singleFile();
    }
}
