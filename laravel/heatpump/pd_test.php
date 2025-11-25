<?php
use Illuminate\Http\Request;
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Request::create('/api/performance-data','POST', [
    'draw' => 1,
    'start' => 0,
    'length' => 5,
]);
$response = $kernel->handle($request);
echo "Status: {$response->getStatusCode()}\n";
echo substr($response->getContent(), 0, 800), "\n";
