<?php

namespace QBH\StoreLanguageBundle\Controller;

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

use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;
use LogicException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ControllerLanguage
 *
 * @Route(
 *      path = "/language",
 * )
 */
class LanguageController extends Controller
{
    /**
     * Language navigator
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return Response Response
     *
     * @throws LogicException No languages available
     *
     * @Route(
     *      path = "/nav",
     *      name = "store_language_nav",
     *      methods = {"GET"}
     * )
     */
    public function navAction(Request $request)
    {
        $languages = $this
            ->get('elcodi.language_manager')
            ->getLanguages();

        if (empty($languages)) {
            throw new LogicException(
                'There are not languages, you must configure at least one'
            );
        }

        return $this->render(
            'StoreLanguageBundle:Partial:language-list.html.twig',
            [
                'languages'      => $languages,
            ]
        );
    }

    /**
     * Switch language to new one
     *
     * @param Request $request Request
     * @param string  $iso     Language iso
     *
     * @return RedirectResponse Last page
     *
     * @Route(
     *      path = "/switch/{iso}",
     *      name = "store_language_switch",
     *      methods = {"GET"}
     * )
     */
    public function switchAction(Request $request, $iso)
    {
        $language = $this
            ->get('elcodi.repository.language')
            ->findOneBy([
                'enabled' => true,
                'iso'     => $iso,
            ]);

        if ($language instanceof LanguageInterface) {
            // TODO: translate URL
            $referrer = $request->headers->get('referer')
                ?: $this->generateUrl('store_homepage');
        }

        return $this->redirect($referrer);
    }
}