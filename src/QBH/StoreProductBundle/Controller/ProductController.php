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
use Mmoreram\ControllerExtraBundle\Annotation\Entity as AnnotationEntity;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;

class ProductController extends Controller
{
    /**
     * Product view
     *
     * @param ProductInterface $product Product
     *
     * @AnnotationEntity(
     *      class = "elcodi.core.product.entity.product.class",
     *      name = "product",
     *      mapping = {
     *          "id" = "~id~",
     *          "enabled" = true,
     *      }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(ProductInterface $product)
    {
        $relatedProducts = $this
            ->get('store.product.service.product_collection_provider')
            ->getRelatedProducts($product, 4);

        $template = $product->hasVariants()
            ? 'StoreProductBundle:Product:product-view-variant.html.twig'
            : 'StoreProductBundle:Product:product-view-item.html.twig';

        return $this->render($template, [
            'product'          => $product,
            'related_products' => $relatedProducts
        ]);
    }
}