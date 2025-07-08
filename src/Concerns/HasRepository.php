<?php

declare(strict_types=1);

namespace Honed\Command\Concerns;

use Honed\Command\Attributes\UseRepository;
use Honed\Command\Repository;
use ReflectionClass;

/**
 * @template TRepository of \Honed\Command\Repository
 *
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 *
 * @property string $repository
 */
trait HasRepository
{
    /**
     * Get the repository manager instance.
     *
     * @return TRepository
     */
    public static function repository(): Repository
    {
        return static::newRepository()
            ?? Repository::repositoryForModel(static::class);
    }

    /**
     * Create a new repository instance for the model.
     *
     * @return TRepository|null
     */
    protected static function newRepository(): ?Repository
    {
        if (isset(static::$repository)) {
            return resolve(static::$repository);
        }

        if ($repository = static::getUseRepositoryAttribute()) {
            return resolve($repository);
        }

        return null;
    }

    /**
     * Get the repository from the Repository class attribute.
     *
     * @return class-string<TRepository>|null
     */
    protected static function getUseRepositoryAttribute(): ?string
    {
        $attributes = (new ReflectionClass(static::class))
            ->getAttributes(UseRepository::class);

        if ($attributes !== []) {
            $repository = $attributes[0]->newInstance();

            return $repository->repositoryClass;
        }

        return null;
    }
}
