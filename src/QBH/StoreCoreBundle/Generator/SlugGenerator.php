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

namespace QBH\StoreCoreBundle\Generator;

use Elcodi\Component\Core\Generator\Interfaces\GeneratorInterface;

class SlugGenerator implements GeneratorInterface
{
    protected $slugifier;

    protected $string;

    public function __construct()
    {
        $this->slugifier = new \Slugifier();
    }

    /**
     * @param mixed $string
     */
    public function setString($string)
    {
        $this->string = $string;
    }

    /**
     * Generates a slug
     *
     * @return string Hash generated
     */
    public function generate()
    {
        return $this->slugifier->slugify($this->string);
    }
}