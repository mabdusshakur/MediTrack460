<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'category',
        'description',
        'price',
        'status',
        'result_type',
        'normal_range',
        'unit',
    ];

    protected $casts = [
        'normal_range' => 'array',
    ];

    public function testItems(): HasMany
    {
        return $this->hasMany(TestItem::class);
    }

    public function testResults(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }
} 