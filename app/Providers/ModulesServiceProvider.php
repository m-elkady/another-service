<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    $modules = glob(base_path('app/Modules') . '/*', GLOB_ONLYDIR);
    foreach ($modules as $module) {
      if (!file_exists($module . '/routes.php')) {
        continue;
      }

      $this->app['router']->group([], function ($router) use ($module) {
        require $module . '/routes.php';
      });
    }
  }
}
