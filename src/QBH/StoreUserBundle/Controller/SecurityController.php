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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ControllerSecurity
 */
class SecurityController extends Controller
{
    /**
     * Login page
     *
     * @param FormView $loginFormView Login form view
     *
     * @return Response Response
     *
     * @AnnotationForm(
     *      class = "store_user_form_type_login",
     *      name  = "loginFormView"
     * )
     */
    public function loginAction(FormView $loginFormView)
    {
        /**
         * If user is already logged, go to redirect url
         */
        if ($this->get('security.context')->isGranted('ROLE_CUSTOMER')) {
            return new RedirectResponse($this->generateUrl('store_homepage'));
        }

        /**
         * Checking for authentication errors in session
         */
        if ($this->get('session')->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $this->get('session')
                ->getFlashBag()
                ->add('error', 'Wrong Email and password combination.');
        }

        return $this->render(
            'Pages:user-login.html.twig',
            [
                'form' => $loginFormView,
            ]
        );
    }
}