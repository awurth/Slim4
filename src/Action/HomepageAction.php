<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class HomepageAction
{
    protected $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(Request $request, Response $response, string $name = ''): ResponseInterface
    {
        return $this->twig->render($response, 'homepage.html.twig', [
            'name' => $name
        ]);
    }
}
