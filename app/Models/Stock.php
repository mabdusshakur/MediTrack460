<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Stock extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'medicine_id',
        'quantity',
        'type',
        'reference',
        'notes',
        'batch_number',
        'expiry_date',
        'purchase_date',
        'purchase_price',
        'status',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'purchase_date' => 'date',
        'purchase_price' => 'decimal:2',
    ];

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['quantity', 'type', 'reference', 'notes', 'status', 'batch_number', 'expiry_date'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
} 