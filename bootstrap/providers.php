<?php

use App\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    Livewire\LivewireServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    Spatie\Activitylog\ActivitylogServiceProvider::class,
];
