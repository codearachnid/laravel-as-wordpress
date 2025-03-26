<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'user_login',
        'user_pass',
        'password',
        'user_nicename',
        'user_email',
        'user_url',
        'user_registered',
        'display_name',
        'remember_token',
    ];

    protected $hidden = [
        'user_pass',
        'password',
        'remember_token',
    ];

    public function getTable()
    {
        return config('wordpress.table_prefix', 'wp_') . $this->table;
    }
    
    /**
     * Override the password attribute to map to user_pass.
     */
    public function getAuthPassword()
    {
        return $this->password ?? $this->user_pass;
    }

    /**
     * Set the password attribute and hash it Laravel-style.
     */
    public function setUserPassAttribute($value)
    {
        $this->attributes['user_pass'] = bcrypt($value);
    }

    /**
     * Check if the password needs rehashing (MD5 -> bcrypt).
     */
    public function passwordNeedsRehash($inputPassword)
    {
        if ($this->password) {
            return Hash::needsRehash($this->password); // Already bcrypt, check if outdated
        }
        return hash('md5', $inputPassword) === $this->user_pass; // Check MD5
    }

    /**
     * Update password to bcrypt if using MD5.
     */
    public function updatePasswordToBcrypt($inputPassword)
    {
        $this->password = $inputPassword; // Triggers bcrypt via setter
        $this->save();
    }

    /**
     * Relationship to usermeta
     */
    public function meta()
    {
        return $this->hasMany(UserMeta::class, 'user_id', 'ID');
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
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's roles from wp_capabilities.
     */
    public function getRolesAttribute()
    {
        $capabilities = $this->meta()
            ->where('meta_key', config('wordpress.table_prefix', 'wp_') . 'capabilities')
            ->first();

        if (!$capabilities || !$capabilities->meta_value) {
            return [];
        }

        $roles = maybe_unserialize($capabilities->meta_value);
        return is_array($roles) ? array_keys(array_filter($roles)) : [];
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole($role)
    {
        return in_array($role, $this->roles);
    }

    /**
     * Check if the user has any of the given roles.
     */
    public function hasAnyRole(array $roles)
    {
        return count(array_intersect($this->roles, $roles)) > 0;
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class, 'user_id', 'ID');
    }
}
