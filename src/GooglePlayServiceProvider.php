<?php namespace RachidLaasri\GooglePlayAPI;

use Illuminate\Support\ServiceProvider;

class GooglePlayServiceProvider extends ServiceProvider {

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('GooglePlay', function(){

            return new GooglePlay(new simple_html_dom);

        });
    }

}
