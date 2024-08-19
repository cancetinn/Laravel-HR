<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

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
        return $this->profile_image 
            ? Storage::url($this->profile_image) 
            : asset('images/default-profile.png');
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
        return $this->roles->flatMap->permissions->pluck('name')->unique();
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shortLeaves()
    {
        return $this->hasMany(ShortLeave::class);
    }

    /**
     * @return string
     */
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

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
