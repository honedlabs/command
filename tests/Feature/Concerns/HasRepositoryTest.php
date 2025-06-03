<?php

declare(strict_types=1);

use Honed\Command\Concerns\HasRepository;
use Illuminate\Database\Eloquent\Model;
use Workbench\App\Models\User;
use Workbench\App\Repositories\UserRepository;

class RepositoryModel extends Model
{
    use HasRepository;

    protected static $repository = UserRepository::class;
}

it('has a repository', function () {
    expect(User::repository())
        ->toBeInstanceOf(UserRepository::class);
});

it('can set repository', function () {
    $model = new RepositoryModel();

    expect($model)
        ->repository()->toBeInstanceOf(UserRepository::class);
});
