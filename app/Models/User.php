<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\UserCredential;
use App\Traits\HasUuidPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuidPrimaryKey, SoftDeletes, HasApiTokens;

    use HasRoles {
        hasRole as traitHasRole;
        hasPermissionTo as traitHasPermissionTo;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'remember_token',
    ];

    protected $guard_name = 'api';

    /**
     * Global Feature Toggle Wrapper for Spatie Permissions.
     * * This method overrides the default Spatie trait behavior to prevent 
     * database queries when the 'roles_permission' feature is disabled. 
     * It ensures the application remains stable even if the underlying 
     * permission tables do not exist in the database.
     */

    public function hasRole($roles, $guard = null): bool
    {
        if (!config('features.roles_permission')) {
            abort(403, "Feature Disabled: Roles & Permissions logic triggered but it is OFF in config.");
            return false;
        }

        try {
            return $this->traitHasRole($roles, $guard);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '42S02') {
                abort(500, "Database Error: Roles & Permissions tables are missing. Please run 'php artisan migrate'.");
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function hasPermissionTo($permission, $guardName = null): bool
    {
        if (!config('features.roles_permission')) {
            abort(403, "Feature Disabled: Roles & Permissions logic triggered but it is OFF in config.");
            return false; 
        }
    
        try {
            return $this->traitHasPermissionTo($permission, $guardName);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '42S02') {
                abort(500, "Database Error: Roles & Permissions tables are missing. Please run 'php artisan migrate'.");
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public function credential()
    {
        return $this->hasOne(UserCredential::class);
    }
}
