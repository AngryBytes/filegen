<?php

namespace Naneau\FileGen\File;

/**
 * Content generator
 */
interface Contents
{
    /**
     * Get the contents for a file
     */
    public function getContents(): string;
}
