<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('openai', function () {
            $clientConfig = [];
            if (config('services.openai.http_proxy')) {
                $clientConfig['proxy'] = config('services.openai.http_proxy');
            }

            return \OpenAI::factory()
                ->withApiKey(config('services.openai.api_key'))
                ->withHttpClient(new Client($clientConfig))
                ->make();
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();


        Passport::personalAccessTokensExpireIn(now()->addDays(2));
    }
}
