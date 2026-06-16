<?php

namespace Tests\Feature;

use App\Http\Middleware\AllowedTrackingIp;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class TrackingAuthTest extends TestCase
{
    public function test_allows_request_when_api_key_is_provided_as_query_parameter(): void
    {
        config(['services.tracking.allowed_ip' => '', 'services.tracking.api_key' => 'secret']);

        $request = Request::create('/api/tracking/alert', 'POST', ['api_key' => 'secret']);
        $request->server->set('REMOTE_ADDR', '192.0.2.1');

        $middleware = new AllowedTrackingIp();

        $response = $middleware->handle($request, static fn(Request $request): Response => new Response('ok', 200));

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('ok', $response->getContent());
    }

    public function test_denies_request_when_ip_and_api_key_are_invalid(): void
    {
        config(['services.tracking.allowed_ip' => '203.0.113.1', 'services.tracking.api_key' => 'secret']);

        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Acceso denegado.');

        $request = Request::create('/api/tracking/alert', 'POST');
        $request->server->set('REMOTE_ADDR', '192.0.2.1');

        $middleware = new AllowedTrackingIp();
        $middleware->handle($request, static fn(Request $request): Response => new Response('ok', 200));
    }
}
