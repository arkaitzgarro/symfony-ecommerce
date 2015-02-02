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
 */

namespace QBH\StoreBundle\DataFixtures\ORM\Category;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslatorInterface;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Factory\CategoryFactory;

/**
 * Class CategoryData
 */
class CategoryData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var CategoryFactory $categoryFactory
         * @var ObjectManager             $categoryObjectManager
         * @var EntityTranslatorInterface $entityTranslator
         */
        $categoryFactory = $this->get('elcodi.factory.category');
        $categoryObjectManager = $this->get('elcodi.object_manager.category');
        $entityTranslator = $this->get('elcodi.entity_translator');

        /**
         * Women's Category
         *
         * @var CategoryInterface $category
         */
        $womenCategory = $categoryFactory
            ->create()
            ->setName('Women')
            ->setSlug('women')
            ->setMetaTitle('Women')
            ->setMetaDescription('Women')
            ->setMetaKeywords('Women')
            ->setEnabled(true)
            ->setRoot(true);

        $categoryObjectManager->persist($womenCategory);
        $this->addReference('category-women', $womenCategory);
        $categoryObjectManager->flush($womenCategory);

        $entityTranslator->save($womenCategory, array(
            'en' => array(
                'name' => 'Women',
                'slug' => 'women',
                'metaTitle' => 'Women',
                'metaDescription' => 'Women',
                'metaKeywords' => 'Women',
            ),
            'es' => array(
                'name' => 'Mujer',
                'slug' => 'mujer',
                'metaTitle' => 'Mujer',
                'metaDescription' => 'Mujer',
                'metaKeywords' => 'Mujer',
            ),
            'fr' => array(
                'name' => 'Femme',
                'slug' => 'femme',
                'metaTitle' => 'Femme',
                'metaDescription' => 'Femme',
                'metaKeywords' => 'Femme',
            )
        ));

        /**
         * Men's Category
         *
         * @var CategoryInterface $menCategory
         */
        $menCategory = $categoryFactory
            ->create()
            ->setName('Men')
            ->setSlug('Men')
            ->setMetaTitle('Men')
            ->setMetaDescription('Men')
            ->setMetaKeywords('Men')
            ->setEnabled(true)
            ->setRoot(true);

        $categoryObjectManager->persist($menCategory);
        $this->addReference('category-men', $menCategory);
        $categoryObjectManager->flush($menCategory);

        $entityTranslator->save($menCategory, array(
            'en' => array(
                'name' => 'Men',
                'slug' => 'men',
                'metaTitle' => 'Men',
                'metaDescription' => 'Men',
                'metaKeywords' => 'Men',
            ),
            'es' => array(
                'name' => 'Hombre',
                'slug' => 'hombre',
                'metaTitle' => 'Hombre',
                'metaDescription' => 'Hombre',
                'metaKeywords' => 'Hombre',
            ),
            'fr' => array(
                'name' => 'Homem',
                'slug' => 'homme',
                'metaTitle' => 'Homme',
                'metaDescription' => 'Homme',
                'metaKeywords' => 'Homme',
            )
        ));
    }
}
