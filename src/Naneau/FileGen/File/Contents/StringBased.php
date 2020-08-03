<?php
namespace Naneau\FileGen\File\Contents;

use Naneau\FileGen\File\Contents;

/**
 * String based file contents
 */
class StringBased implements Contents
{
    /**
     * Contents of the file
     *
     * @var string
     */
    private $contents;

    public function __construct(string $contents)
    {
        $this->setContents($contents);
    }

    /**
     * Get the contents of the file
     */
    public function getContents(): string
    {
        return $this->contents;
    }

    /**
     * Set the contents of the file
     */
    public function setContents(string $contents): self
    {
        $this->contents = $contents;

        return $this;
    }
}
