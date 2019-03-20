<?php

namespace Spatie\MixPreload;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class MixPreloadServiceProvider extends ServiceProvider
{
    public function register()
    {
        Blade::directive('preload', function ($expression) {
            return "<?php echo \Spatie\MixPreload\MixPreload::create($expression)(); ?>";
        });
    }
}
