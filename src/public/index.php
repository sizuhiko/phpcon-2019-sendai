<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Stormiix\Twig\Extension\MixExtension;

require '../../vendor/autoload.php';

$app = new \Slim\App;

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('../view/templates', [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

    $mix = new MixExtension(dirname(__FILE__));
    $view->addExtension($mix);

    return $view;
};

$app->get('/', function (Request $request, Response $response, array $args) {
    return $this->view->render($response, 'index.html');
});

$app->post('/demo', function (Request $request, Response $response, array $args) {
    $parsedBody = $request->getParsedBody();
    $response->getBody()->write(json_encode($parsedBody));
});

$app->run();
