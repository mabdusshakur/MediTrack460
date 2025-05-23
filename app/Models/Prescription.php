<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Prescription extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'token_id',
        'diagnosis',
        'notes',
        'status',
        'next_visit_date',
    ];

    protected $casts = [
        'next_visit_date' => 'date',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function token(): BelongsTo
    {
        return $this->belongsTo(Token::class);
    }

    public function medicineItems(): HasMany
    {
        return $this->hasMany(MedicineItem::class);
    }

    public function testItems(): HasMany
    {
        return $this->hasMany(TestItem::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['diagnosis', 'notes', 'next_visit_date', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
} 