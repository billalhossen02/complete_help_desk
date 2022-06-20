<?php

namespace Cinebaz\SupportTicket;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class SupportTicketProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
      $this->loadRoutesFrom(__DIR__.'/routes/web.php'); 
      $this->loadViewsFrom(__DIR__.'/views', 'billal');
      Paginator::useBootstrap();
      
    }
}
