<?php

namespace App\Models;

use App\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const USER_ROLE  = 'user';
    const ADMIN_ROLE = 'admin';

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'google_id',
        'role',
        'avatar',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRole() {
        return $this->role;
    }

    // Relationships

    public function citations()
    {
        return $this->hasMany(Citation::class, 'users_id');
    }

    public function importedBy()
    {
        return $this->hasMany(ImportRequest::class, 'imported_by');
    }

    public function acceptedImportRequests()
    {
        return $this->hasMany(ImportRequest::class, 'accepted_by');
    }

    public function rejectedImportRequests()
    {
        return $this->hasMany(ImportRequest::class, 'rejected_by');
    }
}
