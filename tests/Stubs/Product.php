<?php

declare(strict_types=1);

namespace Honed\Command\Tests\Stubs;

use Honed\Command\Attributes\Cache;
use Honed\Command\Attributes\Repository;
use Honed\Command\Concerns\HasCache;
use Honed\Command\Concerns\HasRepository;
use Illuminate\Database\Eloquent\Model;

#[Repository(ProductRepository::class)]
#[Cache(ProductCache::class)]
class Product extends Model
{
    /**
     * @use HasCache<ProductCache>
     */
    use HasCache;

    /**
     * @use HasRepository<ProductRepository>
     */
    use HasRepository;

    protected $guarded = [];

    protected $casts = [
        'status' => Status::class,
    ];
}
