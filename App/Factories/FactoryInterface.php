<?php

namespace App\Factories;

interface FactoryInterface
{
    /** gets or creates(if not created already) instances of basic objects
     * 
     * @param string $name
     * 
     * @return object $instance
     */

    public static function get($name = null);

    /**
     * Other methods might be added to create more specific objects
     */
}