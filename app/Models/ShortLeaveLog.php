<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ShortLeave;

class ShortLeaveLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'short_leave_id',
        'admin_id',
        'action',
        'remarks',
    ];

    public function shortLeave()
    {
        return $this->belongsTo(ShortLeave::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
