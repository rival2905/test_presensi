<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'date_of_birth',
        'address',
        'profile_pic'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Accessor untuk URL foto profil
     */
    public function getProfileUrlAttribute()
    {
        if ($this->profile_pic && Storage::disk('public')->exists($this->profile_pic)) {
            return asset('storage/' . $this->profile_pic);
        }
        return asset('assets/img/avatar/avatar-1.png'); // fallback avatar default
    }

    public function affiliations() {
        return $this->hasMany(Affiliation::class, 'user_id');
    }

    public function attendanceRecords() {
        return $this->hasMany(AttendanceRecord::class, 'user_id');
    }

    public function registrations() {
        return $this->hasMany(EventRegistration::class, 'user_id');
    }

    public function subscriptions() {
        return $this->hasMany(Subscription::class, 'user_id');
    }

    public function media() {
        return $this->hasMany(Media::class, 'user_id');
    }

    public function children() {
        return $this->hasMany(ParentChildRelationship::class, 'parent_user_id');
    }

    public function parents() {
        return $this->hasMany(ParentChildRelationship::class, 'child_user_id');
    }
}
