<?php

namespace QBH\StoreUserBundle\Controller;

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Arkaitz Garro <hola@arkaitzgarro.com>
 */

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ControllerUser
 */
class UserController extends Controller
{
    /**
     * User navigator
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/nav",
     *      name = "store_user_nav",
     *      methods = {"GET"}
     * )
     */
    public function navAction()
    {
        return $this->render(
            'StoreUserBundle:Partial:user-nav.html.twig',
            [
            ]
        );
    }
}