<?php

namespace Portal\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class AddApplicantController
{
    private $renderer;

    function __construct(PhpRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    function __invoke(Request $request, Response $response, $args)
    {   
        // MUST BE REMOVED - ONLY FOR TESTING!!!!!!
        $_SESSION['loggedIn'] = true;
        
        if ($_SESSION['loggedIn'] === true) {
            return $this->renderer->render($response, 'addApplicant.phtml', $args);
        } else {
            $_SESSION['loggedIn'] = false;
            return $response->withRedirect('/');
        }
    }
}