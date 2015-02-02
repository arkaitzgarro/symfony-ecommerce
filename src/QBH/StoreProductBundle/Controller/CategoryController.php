<?php

namespace QBH\StoreProductBundle\Controller;

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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Category controller
 */
class CategoryController extends Controller
{
    /**
     * Renders the category nav component
     *
     * @return Response Response
     */
    public function navAction()
    {
        $currentCategoryId = $this
            ->get('request_stack')
            ->getMasterRequest()
            ->get('id');

        $categoryTree = $this
            ->get('elcodi.core.product.service.category_manager')
            ->load();

        return $this->render(
            'StoreProductBundle:Partial:category-list.html.twig',
            [
                'currentCategoryId' => $currentCategoryId,
                'categoryTree'      => $categoryTree,
            ]
        );
    }
}