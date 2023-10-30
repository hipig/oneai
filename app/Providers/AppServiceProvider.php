<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
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
            $client = \OpenAI::factory()
                ->withApiKey(config('services.openai.api_key'));

            if (config('services.openai.base_uri')) {
                $client->withBaseUri(config('services.openai.base_uri'));
            }
            if (config('services.openai.http_proxy')) {
                $client->withHttpClient(new Client([
                    'proxy' => config('services.openai.http_proxy')
                ]));
            }

            return $client->make();
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
