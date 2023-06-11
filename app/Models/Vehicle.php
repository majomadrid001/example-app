<?php

namespace App\Models;

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
}
