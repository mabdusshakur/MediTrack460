<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Medicine extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'generic_name',
        'category',
        'manufacturer',
        'description',
        'unit',
        'price',
        'status',
    ];

    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class);
    }

    public function stockHistory(): HasMany
    {
        return $this->hasMany(Stock::class)->orderBy('created_at', 'desc');
    }

    public function medicineItems(): HasMany
    {
        return $this->hasMany(MedicineItem::class);
    }

    public function prescriptionItems(): HasMany
    {
        return $this->hasMany(MedicineItem::class)->with(['prescription.patient', 'prescription.doctor']);
    }

    public function requisitions(): HasMany
    {
        return $this->hasMany(Requisition::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'generic_name', 'category', 'manufacturer', 'price', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
} 