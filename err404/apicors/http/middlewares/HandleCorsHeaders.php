<?php

namespace Err404\ApiCors\Http\Middlewares;

class HandleCorsHeaders
{
    /** @var string */
    protected static $defaultsHeaders = 'Authorization, Content-Type, Origin, Accept-Language, Content-Language';

    /** @var string */
    protected static $defaultsMethods = 'GET, HEAD, POST, PUT, DELETE, CONNECT, OPTIONS, TRACE, PATCH';

    /** @var string */
    protected static $defaultsCredentials = 'false';

    public $headers;

    public function __construct()
    {
        $this->headers = self::prepareHeaders();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|mixed
     */
    public function handle($request, \Closure $next)
    {
        if ($request->isMethod('OPTIONS')) {
            return response('', 200, $this->headers);
        }

        $response = $next($request);
        $response->headers->add($this->headers);

        return $response;
    }

    protected static function prepareHeaders(): array
    {
        return [
            'Access-Control-Allow-Origin'       => config('err404.apicore::origin', '*'),
            'Access-Control-Allow-Headers'      => config('err404.apicore::headers', self::$defaultsHeaders),
            'Access-Control-Allow-Methods'      => config('err404.apicore::methods', self::$defaultsMethods),
            'Access-Control-Allow-Credentials'  => config(
                'err404.apicore::credentials',
                self::$defaultsCredentials
            ),
        ];
    }
}
