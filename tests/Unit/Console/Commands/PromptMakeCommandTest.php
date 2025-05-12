<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Prompts'));
});

it('makes', function () {
    $this->artisan('make:prompt', [
        'name' => 'MarkdownPrompt',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Prompts/MarkdownPrompt.php'));
});

it('prompts for a name', function () {
    $this->artisan('make:prompt', [
        '--force' => true,
    ])->expectsQuestion('What should the prompt be named?', 'MarkdownPrompt')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Prompts/MarkdownPrompt.php'));
});