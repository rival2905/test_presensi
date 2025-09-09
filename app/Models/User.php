<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'date_of_birth',
        'address',
        'profile_pic'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
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
