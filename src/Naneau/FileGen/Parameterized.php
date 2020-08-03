<?php
namespace Naneau\FileGen;

/**
 * Parameterized class
 */
interface Parameterized
{
    /**
     * Get the parameters
     *
     * @return string[]
     */
    public function getParameters();

    /**
     * Set the parameters
     *
     * @param string[] $parameters
     */
    public function setParameters(array $parameters): self;
}
