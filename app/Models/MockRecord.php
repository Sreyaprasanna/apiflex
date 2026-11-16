<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MockRecord extends Model
{
    protected $fillable = ['api_table_id', 'data'];

    protected $casts = [
        'data' => 'array',
    ];

    public function apiTable()
    {
        return $this->belongsTo(ApiTable::class);
    }
}