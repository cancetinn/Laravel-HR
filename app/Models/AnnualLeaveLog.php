<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnualLeaveLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'previous_total_leaves',
        'new_total_leaves',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
