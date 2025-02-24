<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BaseModel extends Model
{
    use SoftDeletes;

    protected $guarded = ['id', 'updated_at', '_token', '_method'];
    protected $dates = ['deleted_at', 'published_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::id() ?? 1;
            $model->created_at = Carbon::now();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id() ?? 1;
        });

        static::saving(function ($model) {
            $model->updated_by = Auth::id() ?? 1;
        });

        static::deleting(function ($model) {
            $model->deleted_by = Auth::id() ?? 1;
            $model->save();
        });
    }

    public function getTableColumns()
    {
        return DB::select(DB::raw('SHOW COLUMNS FROM ' . $this->getTable()));
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = empty($value) ? slug_format($this->attributes['name']) : slug_format($value);
    }
}
