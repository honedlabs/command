<?php

declare(strict_types=1);

namespace Honed\Command;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Throwable;

use function implode;
use function is_array;

/**
 * @template TParameter = mixed
 * @template TReturn = mixed
 */
abstract class CacheManager
{
    /**
     * The default namespace where caches reside.
     *
     * @var string
     */
    public static $namespace = 'App\\Caches\\';

    /**
     * The duration of the cache.
     *
     * @var int|array{int, int}|null
     */
    protected $duration;

    /**
     * The default duration of the cache.
     *
     * @var int|array{int, int}
     */
    protected static $useDuration = 0;

    /**
     * How to resolve the cache name for the given class name.
     *
     * @var (Closure(class-string):class-string<CacheManager>)|null
     */
    protected static $cacheNameResolver;

    /**
     * Define the key of the cache.
     *
     * @param  TParameter  $parameter
     * @return string|array<int,string|int>
     */
    abstract public function key($parameter);

    /**
     * Define the value of the cache.
     *
     * @param  TParameter  $parameter
     * @return TReturn
     */
    abstract public function value($parameter);

    /**
     * Get the value of the cache.
     *
     * @param  TParameter  $parameter
     * @return TReturn
     */
    public static function get($parameter = null)
    {
        return resolve(static::class)->retrieve($parameter);
    }

    /**
     * Forget the cache value.
     *
     * @param  TParameter  $parameter
     * @return void
     */
    public static function forget($parameter = null)
    {
        resolve(static::class)->flush($parameter);
    }

    /**
     * Get the cache manager for a class.
     *
     * @param  class-string  $class
     * @return CacheManager
     */
    public static function cacheForModel($class)
    {
        $cache = static::resolveCacheName($class);

        return resolve($cache);
    }

    /**
     * Get the table name for the given model name.
     *
     * @param  class-string  $className
     * @return class-string<CacheManager>
     */
    public static function resolveCacheName($className)
    {
        $resolver = static::$cacheNameResolver ?? function (string $className) {
            $appNamespace = static::appNamespace();

            $className = Str::startsWith($className, $appNamespace.'Models\\')
                ? Str::after($className, $appNamespace.'Models\\')
                : Str::after($className, $appNamespace);

            /** @var class-string<CacheManager> */
            return static::$namespace.$className.'Cache';
        };

        return $resolver($className);
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
     * @param  Closure(class-string):class-string<CacheManager>  $callback
     * @return void
     */
    public static function guessCacheNamesUsing($callback)
    {
        static::$cacheNameResolver = $callback;
    }

    /**
     * Flush the cache's global configuration state.
     *
     * @return void
     */
    public static function flushState()
    {
        static::$cacheNameResolver = null;
        static::$namespace = 'App\\Caches\\';
    }

    /**
     * Define the duration of the cache.
     *
     * @return int|null
     */
    public function duration()
    {
        return null;
    }

    /**
     * Get the duration of the cache.
     *
     * @return int|array{int, int}
     */
    public function getDuration()
    {
        return $this->duration()
            ?? $this->duration
            ?? static::$useDuration;
    }

    /**
     * Get the key of the cache.
     *
     * @param  TParameter  $parameter
     * @return string
     */
    public function getKey($parameter)
    {
        $key = $this->key($parameter);

        if (is_array($key)) {
            $key = implode('.', $key);
        }

        return $key;
    }

    /**
     * Retrieve the cache value.
     *
     * @param  TParameter  $parameter
     * @return TReturn
     */
    public function retrieve($parameter)
    {
        $duration = $this->getDuration();

        return match (true) {
            is_array($duration) => Cache::flexible(
                $this->getKey($parameter),
                $duration,
                fn () => $this->value($parameter)
            ),

            $duration < 0 => $this->value($parameter),

            $duration > 0 => Cache::remember(
                $this->getKey($parameter),
                $duration,
                fn () => $this->value($parameter)
            ),

            default => Cache::rememberForever(
                $this->getKey($parameter),
                fn () => $this->value($parameter)
            )
        };
    }

    /**
     * Flush all caches under the same namespace.
     *
     * @param  TParameter  $parameter
     * @return void
     */
    public function flush($parameter)
    {
        Cache::forget($this->getKey($parameter));
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
        } catch (Throwable) {
            return 'App\\';
        }
    }
}
