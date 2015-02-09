<?php

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

namespace QBH\StoreCartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityNotFoundException;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as AnnotationEntity;
use Mmoreram\ControllerExtraBundle\Annotation\Form as AnnotationForm;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;

class CartController extends Controller
{
    /**
     * Cart view
     *
     * @param FormType      $formType Form type
     * @param CartInterface $cart     Cart
     *
     * @return array
     *
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "elcodi.cart_wrapper",
     *          "method" = "loadCart",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     * @AnnotationForm(
     *      class = "store_cart_form_type_cart",
     *      name  = "formView",
     *      entity = "cart",
     * )
     */
    public function viewAction(
        FormType $formType,
        CartInterface $cart
    )
    {
        $relatedProducts = [];

        if ($cart->getCartLines()->count()) {

            $relatedProducts = $this
                ->get('store.product.service.product_collection_provider')
                ->getRelatedProducts($cart
                    ->getCartLines()
                    ->first()
                    ->getProduct()
                    , 3);
        }

        /**
         * Let's sort the cartLines if needed
         */
        $cart->setCartLines(
            $this
                ->get('elcodi.cart_lines_sorter')
                ->sortCartLines($cart->getCartLines())
        );

        $cartCoupons = $this
            ->get('elcodi.cart_coupon_manager')
            ->getCartCoupons($cart);

        $formView = $this
            ->get('form.factory')
            ->create($formType, $cart)
            ->createView();

        return $this->render('StoreCartBundle:Cart:view.html.twig', [
            'cart'             => $cart,
            'cartcoupon'       => $cartCoupons,
            'form'             => $formView,
            'related_products' => $relatedProducts
        ]);
    }

    /**
     * Adds item into cart
     *
     * @param Request          $request Request object
     * @param ProductInterface $product Product id
     * @param CartInterface    $cart    Cart
     *
     * @return Response Redirect response
     *
     * @throws EntityNotFoundException product not found
     *
     * @AnnotationEntity(
     *      class = "elcodi.core.product.entity.product.class",
     *      name = "product",
     *      mapping = {
     *          "id" = "~id~",
     *          "enabled" = true,
     *      }
     * )
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "elcodi.cart_wrapper",
     *          "method" = "loadCart",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     */
    public function addProductAction(
        Request $request,
        ProductInterface $product,
        CartInterface $cart
    )
    {
        if ($request->request->get('add-cart-is-variant')) {
            /**
             * We are adding a Product with variant,
             * we should identify the Variant given
             * the submitted attribute/options
             */
            $optionIds = $request->request->get('variant-option-for-attribute');

            $purchasable = $this
                ->get('elcodi.repository.variant')
                ->findByOptionIds($product, $optionIds);

            if (!($purchasable instanceof VariantInterface)) {

                throw new EntityNotFoundException($this
                    ->container
                    ->getParameter('elcodi.core.product.entity.variant.class'));
            }

        } else {
            /**
             * There is no variant, add the Product as is
             */
            $purchasable = $product;
        }

        $this
            ->get('elcodi.cart_manager')
            ->addProduct(
                $cart,
                $purchasable,
                (int) $request->request->get('add-cart-quantity', 1)
            );

        return $this->redirect(
            $this->generateUrl('store_cart_view')
        );
    }
}