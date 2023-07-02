<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Vehicle extends Model
{
    use HasFactory;

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function types(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function usecases(): BelongsTo
    {
        return $this->belongsTo(Usecase::class);
    }

    public function scopeOfType(Builder $query, Type $type): void
    {
        $query->where('type_id', $type->id);
    }

    public function scopeOfUsecase(Builder $query, Usecase $usecase): void
    {
        $query->where('usecase_id', $usecase->id);
    }

    public function scopePriceFrom(Builder $query, int $price): void
    {
        $query->where('price', '>=', $price);
    }

    public function scopePriceTo(Builder $query, int $price): void
    {
        $query->where('price', '<=', $price);
    }

    public function scopeHasRange(Builder $query, int $range): void
    {
        $query->where('range', '>=', $range);
    }

   public function scopeAllowedForMotorways(Builder $query): void
   {
       $query->where('motorway', 1);
   }

    public function scopeDriversLicenseNeeded(Builder $query): void
    {
        $query->where('drivers_license', 1);
    }

    public function scopeWithTopBox(Builder $query): void
    {
        $query->where('top_box', 1);
    }

    public function scopeOrderByPrice(Builder $query, int $orderby): void
    {
        if ($orderby==1) {
            $query->orderBy('price', 'asc');
        } else {
            $query->orderBy('price', 'desc');
        }
    }
}
