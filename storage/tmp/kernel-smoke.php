<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$paths = ['/', '/login', '/courses'];
foreach ($paths as $path) {
    $request = Illuminate\Http\Request::create($path, 'GET');
    $response = $kernel->handle($request);
    echo $path . ' => ' . $response->getStatusCode() . PHP_EOL;
    $kernel->terminate($request, $response);
}
