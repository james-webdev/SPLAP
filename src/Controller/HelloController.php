<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController
{
    #[Route('hello', name: 'splap_hello')]
public function index(): Response
{
return new Response('Hello');
}
}