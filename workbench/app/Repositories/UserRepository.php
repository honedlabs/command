<?php

declare(strict_types=1);

namespace Workbench\App\Repositories;

use Honed\Command\Repository;
use Workbench\App\Models\User;

/**
 * @template TModel of \Workbench\App\Models\User
 */
class UserRepository extends Repository
{
    /**
     * Create a new repository instance.
     *
     * @param  TModel  $user
     */
    public function __construct(
        protected User $user
    ) {}
}
