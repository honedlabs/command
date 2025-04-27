<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Queries'));
});

it('makes', function () {
    $this->artisan('make:query', [
        'name' => 'TrendingQuestionsFeed',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Queries/TrendingQuestionsFeed.php'));
});

it('prompts for a name', function () {
    $this->artisan('make:query', [
        '--force' => true,
    ])->expectsQuestion('What should the query be named?', 'TrendingQuestionsFeed')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Queries/TrendingQuestionsFeed.php'));
});