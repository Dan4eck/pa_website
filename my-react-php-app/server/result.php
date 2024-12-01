<?php
require 'vendor/autoload.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Create Slim app
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Result URL handler
$app->post('/robokassa/result', function (Request $request, Response $response) {
    // Get parameters from request
    $params = $request->getParsedBody();
    
    // Required parameters
    $outSum = $params['OutSum'] ?? '';
    $invId = $params['InvId'] ?? '';
    $signatureValue = $params['SignatureValue'] ?? '';
    
    // Get password from environment variables
    $password2 = $_ENV['pa_website_password2'];
    
    // Build our signature
    $mySignature = strtoupper(md5("$outSum:$invId:$password2"));
    
    // Verify signature
    if ($mySignature !== strtoupper($signatureValue)) {
        $response->getBody()->write("bad sign\n");
        return $response->withStatus(400);
    }
    
    // Verify amount (should be 20 rubles as per PRD)
    if ((float)$outSum !== 20.00) {
        $response->getBody()->write("invalid amount\n");
        return $response->withStatus(400);
    }
    
    // If everything is correct, return OK{InvId}
    $response->getBody()->write("OK$invId");
    return $response
        ->withHeader('Content-Type', 'text/plain')
        ->withStatus(200);
});

// Run the app
$app->run();
