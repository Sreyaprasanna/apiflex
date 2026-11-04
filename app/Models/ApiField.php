<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiField extends Model
{
    protected $fillable = [
        'api_table_id',
        'name',
        'type',
        'required',
    ];

    public function table()
    {
        return $this->belongsTo(ApiTable::class, 'api_table_id');
    }
}
