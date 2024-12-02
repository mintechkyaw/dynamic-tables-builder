<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $incrementing = false;

    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }

    protected $fillable = [
        'name',
        'email',
        'role_id',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'id' => 'string',
    ];

    public function isSuperAdmin()
    {
        return $this->role->name === 'superAdmin' || $this->permissions()->where('name', 'manage-all')->exists();
    }

    public function hasPermissionTo(string $permissionName)
    {
        return $this->permissions()->where('name', $permissionName)->exists() ? true : false;
    }

    public function forms()
    {
        return $this->hasMany(Form::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
