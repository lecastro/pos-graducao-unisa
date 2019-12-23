<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp;

class GetNetToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $seller_id     = env('SELLER_ID');
        $client_id     = env('CLIENT_ID');
        $client_secret = env('CLIENT_SECRET');
        $url_api       = env('URL_API');
        $url_js        = env('URL_JS');

        $auth_string = base64_encode($client_id.':'.$client_secret);

        $guzzle = new GuzzleHttp\Client;

        $response = $guzzle->post($url_api, [
            'headers' => [
                'Accept'        => 'application/json, text/plain, */*',
                'Content-Type'  => 'application/x-www-form-urlencoded',
                'Authorization' => 'Basic '.$auth_string,
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
                'scope'      => 'oob',
            ],
        ]);

        $request->headers->add(json_decode((string) $response->getBody(), true));

        $request->request->add([
            'seller_id' => $seller_id,
            'url_js'    => $url_js
        ]);

        return $next($request);
    }
}
