<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class HelloWorldController extends Controller
{
    private $foo;
    private $twig;
    private $router;

    public function __construct(Environment $twig, UrlGeneratorInterface $router, string $foo)
    {
        $this->foo = $foo;
        $this->twig = $twig;
        $this->router = $router;
    }

    /**
     * @Route("/hello", name="hello", methods="GET")
     */
    public function hello(): Response
    {
        return new Response($this->twig->render('hello.html.twig', [
            'foo' => 'bar',
            'url' => $this->router->generate('hello'),
        ]));
    }
}