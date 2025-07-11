<?php

declare(strict_types=1);

namespace Honed\Command;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Str;
use Throwable;

abstract class Repository
{
    /**
     * The default namespace where repositories reside.
     *
     * @var string
     */
    public static $namespace = 'App\\Repositories\\';

    /**
     * How to resolve the repository name for the given class name.
     *
     * @var (Closure(class-string):class-string<Repository>)|null
     */
    protected static $repositoryNameResolver;

    /**
     * Get the repository for a class.
     *
     * @param  class-string  $class
     */
    public static function repositoryForModel(string $class): self
    {
        $repository = static::resolveRepositoryName($class);

        return resolve($repository);
    }

    /**
     * Get the table name for the given model name.
     *
     * @param  class-string  $className
     * @return class-string<Repository>
     */
    public static function resolveRepositoryName(string $className): string
    {
        $resolver = static::$repositoryNameResolver ?? function (string $className) {
            $appNamespace = static::appNamespace();

            $className = Str::startsWith($className, $appNamespace.'Models\\')
                ? Str::after($className, $appNamespace.'Models\\')
                : Str::after($className, $appNamespace);

            /** @var class-string<Repository> */
            return static::$namespace.$className.'Repository';
        };

        return $resolver($className);
    }

    /**
     * Specify the default namespace that contains the application's model tables.
     */
    public static function useNamespace(string $namespace): void
    {
        static::$namespace = $namespace;
    }

    /**
     * Specify the callback that should be invoked to guess the name of a model table.
     *
     * @param  Closure(class-string):class-string<Repository>  $callback
     */
    public static function guessRepositoryNamesUsing(Closure $callback): void
    {
        static::$repositoryNameResolver = $callback;
    }

    /**
     * Flush the repository's global configuration state.
     */
    public static function flushState(): void
    {
        static::$repositoryNameResolver = null;
        static::$namespace = 'App\\Repositories\\';
    }

    /**
     * Get the application namespace for the application.
     */
    protected static function appNamespace(): string
    {
        try {
            return Container::getInstance()
                ->make(Application::class)
                ->getNamespace();
        } catch (Throwable) {
            return 'App\\';
        }
    }
}
