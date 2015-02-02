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

namespace QBH\StoreBundle\DataFixtures\ORM\Language;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Language\Factory\LanguageFactory;

/**
 * Class LanguageData
 */
class LanguageData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $languageObjectManager = $this->get('elcodi.object_manager.language');
        $languageFactory  = $this->get('elcodi.factory.language');
        $entityTranslator = $this->get('elcodi.entity_translator');

        /**
         * @var LanguageInterface $language
         */
        $es = $languageFactory
            ->create()
            ->setIso('es')
            ->setName('Spanish')
            ->setEnabled(true);

        $languageObjectManager->persist($es);
        $languageObjectManager->flush($es);

        $entityTranslator->save($es, array(
            'es' => array(
                'name' => 'Español'
            ),
            'en' => array(
                'name' => 'Spanish'
            ),
            'fr' => array(
                'name' => 'Fraçais'
            )
        ));

        /**
         * @var LanguageInterface $language
         */
        $en = $languageFactory
            ->create()
            ->setIso('en')
            ->setName('English')
            ->setEnabled(true);

        $languageObjectManager->persist($en);
        $languageObjectManager->flush($en);

        $entityTranslator->save($en, array(
            'es' => array(
                'name' => 'Inglés'
            ),
            'en' => array(
                'name' => 'English'
            ),
            'fr' => array(
                'name' => 'Fraçais'
            )
        ));

        /**
         * @var LanguageInterface $language
         */
        $fr = $languageFactory
            ->create()
            ->setIso('fr')
            ->setName('French')
            ->setEnabled(false);

        $languageObjectManager->persist($fr);
        $languageObjectManager->flush($fr);

        $entityTranslator->save($fr, array(
            'es' => array(
                'name' => 'Francés'
            ),
            'en' => array(
                'name' => 'French'
            ),
            'fr' => array(
                'name' => 'Fraçais'
            )
        ));
    }
}
