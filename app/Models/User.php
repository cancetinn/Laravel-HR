<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use App\Models\AnnualLeave; // AnnualLeave modelini içe aktardığınızdan emin olun

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Rol alanı: 0 (normal kullanıcı), 1 (admin)
        'first_name',
        'last_name',
        'title',
        'phone',
        'profile_image',
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
     * Kullanıcının admin olup olmadığını kontrol eder.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 1;
    }

    /**
     * Profil resmi URL'sini alır.
     *
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
     * Kullanıcının rolleriyle ilişkisini tanımlar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Kullanıcının belirli bir role sahip olup olmadığını kontrol eder.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * Kullanıcının sahip olduğu tüm izinleri alır.
     *
     * @return \Illuminate\Support\Collection
     */
    public function permissions()
    {
        return $this->roles->map->permissions->flatten()->pluck('name')->unique();
    }

    /**
     * Kullanıcının belirli bir izne sahip olup olmadığını kontrol eder.
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return $this->permissions()->contains($permission);
    }

    /**
     * Kullanıcının izin talepleriyle ilişkisini tanımlar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    /**
     * Kullanıcının yıllık izinleriyle ilişkisini tanımlar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function annualLeaves()
    {
        return $this->hasMany(AnnualLeave::class);
    }
}
