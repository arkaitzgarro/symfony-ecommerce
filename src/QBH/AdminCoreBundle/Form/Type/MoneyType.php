<?php

/**
 * This file is part of the Symfony Base project, and it's based on Elcodi project
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

namespace QBH\AdminCoreBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use QBH\AdminCoreBundle\Form\DataTransformer\MoneyDecimalTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Wrapper\CurrencyWrapper;

/**
 * Class MoneyType
 * @package QBH\AdminCoreBundle\Form\Type
 */
class MoneyType extends AbstractType
{
    /**
     * @var CurrencyWrapper
     *
     * Currency Wrapper
     */
    protected $currencyManager;

    /**
     * @var string
     *
     * Default currency
     */
    protected $defaultCurrency;

    /**
     * @var MoneyDecimalTransformer
     *
     * Money amount transformer
     */
    protected $transformer;

    /**
     * Construct method
     *
     * @param CurrencyWrapper $currencyWrapper Currency Wrapper
     * @param string          $defaultCurrency Default Currency
     */
    public function __construct(
        CurrencyWrapper $currencyWrapper,
        $defaultCurrency
    )
    {
        $this->currencyWrapper = $currencyWrapper;
        $this->defaultCurrency = $defaultCurrency;
        $this->transformer = new MoneyDecimalTransformer();
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                $builder->create('amount', 'number', array('precision' => 2))
                    ->addModelTransformer($this->transformer)
            )
            ->add('currency', 'entity', [
                'class'         => 'QBH\StoreCurrencyBundle\Entity\Currency',
                'query_builder' => function (EntityRepository $repository) {
                    return $repository
                        ->createQueryBuilder('c')
                        ->where('c.enabled = :enabled')
                        ->setParameter('enabled', true);
                },
                'required'      => true,
                'multiple'      => false,
                'property'      => 'symbol',
                'data'          => $this->defaultCurrency,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        /**
         * We set given Currency as default object to work with
         */
        $money = Money::create(
            0,
            $this->currencyWrapper->getDefaultCurrency()
        );
        $resolver->setDefaults(array(
            'data_class' => 'Elcodi\Component\Currency\Entity\Money',
            'empty_data' => $money,
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'money_object';
    }
}