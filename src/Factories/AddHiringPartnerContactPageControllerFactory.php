<?php

namespace Portal\Factories;

use Psr\Container\ContainerInterface;
use Portal\Controllers\FrontEnd\AddHiringPartnerContactPageController;

class AddHiringPartnerContactPageControllerFactory
{
    /**
     * Instantiates DisplayHiringPartnerPageController with dependencies.
     *
     * @param ContainerInterface $container
     *
     * @return AddHiringPartnerContactPageController
     */

    public function __invoke(ContainerInterface $container) : AddHiringPartnerContactPageController
    {
        $renderer = $container->get('renderer');
        $hiringPartnerModel = $container->get('HiringPartnerModel');
        return new AddHiringPartnerContactPageController($renderer, $hiringPartnerModel);
    }
}
