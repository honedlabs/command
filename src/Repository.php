<?php

declare(strict_types=1);

namespace Honed\Command;

use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Str;

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
     * @var (\Closure(class-string):class-string<\Honed\Command\Repository>)|null
     */
    protected static $repositoryNameResolver;

    /**
     * Get the repository for a class.
     *
     * @param  class-string  $class
     * @return \Honed\Command\Repository
     */
    public static function repositoryForModel($class)
    {
        $repository = static::resolveRepositoryName($class);

        return resolve($repository);
    }

    /**
     * Get the table name for the given model name.
     *
     * @param  class-string  $className
     * @return class-string<\Honed\Command\Repository>
     */
    public static function resolveRepositoryName($className)
    {
        $resolver = static::$repositoryNameResolver ?? function (string $className) {
            $appNamespace = static::appNamespace();

            $className = Str::startsWith($className, $appNamespace.'Models\\')
                ? Str::after($className, $appNamespace.'Models\\')
                : Str::after($className, $appNamespace);

            /** @var class-string<\Honed\Command\Repository> */
            return static::$namespace.$className.'Repository';
        };

        return $resolver($className);
    }

    /**
     * Get the application namespace for the application.
     *
     * @return string
     */
    protected static function appNamespace()
    {
        try {
            return Container::getInstance()
                ->make(Application::class)
                ->getNamespace();
        } catch (\Throwable) {
            return 'App\\';
        }
    }

    /**
     * Specify the default namespace that contains the application's model tables.
     *
     * @param  string  $namespace
     * @return void
     */
    public static function useNamespace($namespace)
    {
        static::$namespace = $namespace;
    }

    /**
     * Specify the callback that should be invoked to guess the name of a model table.
     *
     * @param  \Closure(class-string):class-string<\Honed\Command\Repository>  $callback
     * @return void
     */
    public static function guessRepositoryNamesUsing($callback)
    {
        static::$repositoryNameResolver = $callback;
    }

    /**
     * Flush the repository's global configuration state.
     *
     * @return void
     */
    public static function flushState()
    {
        static::$repositoryNameResolver = null;
        static::$namespace = 'App\\Repositories\\';
    }
}
