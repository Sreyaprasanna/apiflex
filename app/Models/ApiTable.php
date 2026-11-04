<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiTable extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'slug',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function fields()
    {
        return $this->hasMany(ApiField::class);
    }
}
