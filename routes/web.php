<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Livewire\Articles\IndexArticles;
use App\Livewire\Articles\CreateArticles;
use App\Livewire\Articles\ViewArticles;
use App\Livewire\Articles\EditArticles;
use App\Livewire\Assessment\IndexAssessment;
use App\Livewire\Assessment\CreateAssessment;
use App\Livewire\Dashboard;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');


Route::middleware(['auth'])->group(function () {
    Volt::route('dashboard', Dashboard::class)->name('dashboard');

    Volt::route('articles', IndexArticles::class)->name('articles.index');
    Volt::route('articles/create', CreateArticles::class)->name('articles.create');
    Volt::route('articles/{slug}', ViewArticles::class)->name('articles.view');
    Volt::route('articles/{slug}/edit', CreateArticles::class)->name('articles.edit');

    Volt::route('assessment', IndexAssessment::class)->name('assessment.index');
    Volt::route('assessment/create', CreateAssessment::class)->name('assessment.create');
    Volt::route('assessment/edit/{token}', CreateAssessment::class)->name('assessment.edit');

});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});



require __DIR__.'/auth.php';
