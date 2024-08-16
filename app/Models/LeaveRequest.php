<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'start_date',
        'end_date',
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

    /**
     * @return bool
     */
    public function isActive()
    {
        return Carbon::now()->between($this->start_time, $this->end_time);
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        return Carbon::now()->greaterThan($this->end_time);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        $now = Carbon::now();
        return $query->where('date', $now->toDateString())
                    ->where('end_time', '>', $now->toTimeString());
    }
}
