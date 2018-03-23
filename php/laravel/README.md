### Accept json
```php
// AcceptJsonMiddleware.php
<?php

namespace App\Http\Middleware;

class AcceptJsonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, $next)
    {
        $request->headers->set('accept', 'application/json', true);

        return $next($request);
    }
}

// Http/Kernel.php
protected $middlewareGroups = [
    'api' => [
        'accept.json',
    ],
];

protected $routeMiddleware = [
    'accept.json' => \App\Http\Middleware\AcceptJsonMiddleware::class,
];
```

### Timestamps
```php
$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
$table->timestamp('created_at')->useCurrent();
```
