<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use App\Models\AnnualLeave;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'first_name',
        'last_name',
        'title',
        'phone',
        'profile_image',
        'department',
        'joining_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 1;
    }

    /**
     * @return string
     */
    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            return Storage::url($this->profile_image);
        }
        return asset('images/default-profile.png');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function permissions()
    {
        return $this->roles->map->permissions->flatten()->pluck('name')->unique();
    }

    /**
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return $this->permissions()->contains($permission);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function annualLeaves()
    {
        return $this->hasMany(AnnualLeave::class);
    }
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    public function shortLeaves()
    {
        return $this->hasMany(ShortLeave::class);
    }

    public function getDepartmentNameAttribute()
    {
        $departments = [
            1 => 'Grafik Tasarım',
            2 => 'Yazılım',
            3 => 'İçerik Ekibi',
            4 => 'SEO',
        ];

        return $departments[$this->department] ?? 'Bilinmiyor';
    }
}
