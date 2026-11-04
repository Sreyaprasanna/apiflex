<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'database_name',
        'description',
    ];


    public function tables()
    {
        return $this->hasMany(ApiTable::class);
    }

    public function getSlugAttribute()
    {
        return $this->database_name;
    }

}

