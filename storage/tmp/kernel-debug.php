<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
foreach (['/', '/courses'] as $path) {
  $request = Illuminate\Http\Request::create($path, 'GET');
  $response = $kernel->handle($request);
  echo "=== $path ===\n";
  echo $response->getStatusCode() . "\n";
  echo substr($response->getContent(), 0, 1200) . "\n\n";
  $kernel->terminate($request, $response);
}
