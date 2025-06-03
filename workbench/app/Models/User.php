<?php

declare(strict_types=1);

namespace Workbench\App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Honed\Command\Attributes\Cache;
use Honed\Command\Attributes\Repository;
use Honed\Command\Concerns\HasCache;
use Honed\Command\Concerns\HasRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Workbench\App\Caches\UserCache;
use Workbench\App\Repositories\UserRepository;
use Workbench\Database\Factories\UserFactory;

#[Repository(UserRepository::class)]
#[Cache(UserCache::class)]
class User extends Authenticatable
{
    /**
     * @use \Honed\Command\Concerns\HasCache<\Workbench\App\Caches\UserCache>
     */
    use HasCache;

    /**
     * @use \Illuminate\Database\Eloquent\Factories\HasFactory<\Workbench\Database\Factories\UserFactory>
     */
    use HasFactory;

    /**
     * @use \Honed\Command\Concerns\HasRepository<\Workbench\App\Repositories\UserRepository>
     */
    use HasRepository;

    use Notifiable;

    /**
     * {@inheritdoc}
     */
    protected static $factory = UserFactory::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'password' => 'hashed',
    ];
}
