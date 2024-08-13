<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ShortLeave extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'start_time',
        'end_time',
        'reason',
        'duration',
        'status',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isActive()
    {
        $currentDateTime = now();
        return $currentDateTime->between($this->start_time, $this->end_time);
    }

    public function isExpired()
    {
        return now()->gt($this->end_time);
    }

    public function scopeActive($query)
    {
        return $query->where('date', now()->toDateString())
                    ->where('end_time', '>', now()->toTimeString());
    }

}
