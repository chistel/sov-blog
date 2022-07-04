<?php

namespace App\Models\Users;

use App\Abstracts\AuthenticationModel;
use App\Models\Article;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class User extends AuthenticationModel
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    public const CREATED_REGISTER = 'register';
    public const CREATED_IMPORT = 'import';
    public const CREATED_SOCIAL = 'social';
    public const CREATED_INVITED = 'invited';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lastSeen',
        'firstName',
        'lastName',
        'email',
        'password',
        'refCode',
        'emailVerifiedAt',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Model's boot function
     */
    public static function boot()
    {
        parent::boot();

        static::saving(static function (self $user) {
            // Hash user password, if not already hashed
            if (!is_null($user->password) && Hash::needsRehash($user->password)) {
                $user->password = Hash::make($user->password);
            }
        });
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    /**
     * Convert email addresses to lowercase.
     *
     * @param string $email
     */
    public function setEmailAttribute($email): void
    {
        $email = ($email ? strtolower($email) : null);
        $existing = Arr::get($this->attributes, 'email');

        $this->attributes['email'] = $email;
    }

    /**
     * First name attribute mutator
     *
     * @param $value
     */
    public function setFirstNameAttribute($value): void
    {
        $this->attributes['first_name'] = trim($value);
    }

    /**
     * Last name attribute mutator
     *
     * @param $value
     */
    public function setLastNameAttribute($value): void
    {
        $this->attributes['last_name'] = trim($value);
    }


    /**
     * Get the customer full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }


    /**
     * The posts.
     *
     * @return HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Get the author's avatar.
     *
     * @param string $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        return $value ?: 'https://secure.gravatar.com/avatar/' . md5(strtolower(trim($this->email))) . '?s=80';
    }
}
