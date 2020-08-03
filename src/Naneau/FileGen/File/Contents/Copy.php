<?php
namespace Naneau\FileGen\File\Contents;

use Naneau\FileGen\File\Contents\Exception as ContentsException;
use Naneau\FileGen\File\Contents;

/**
 * Contents for a file copied directly from another
 */
class Copy implements Contents
{
    /**
     * The source file
     *
     * @var string
     */
    private $from;

    public function __construct(string $from)
    {
        $this->setFrom($from);
    }

    /**
     * Get the contents
     */
    public function getContents(): string
    {
        // Make sure file exists
        if (!file_exists($this->getFrom()) || !is_readable($this->getFrom())) {
            throw new ContentsException(sprintf(
                'Can not read from "%s"',
                $this->getFrom()
            ));
        }

        $contents = file_get_contents($this->getFrom());

        if ($contents === false) {
            throw new ContentsException(sprintf(
                'Could not read from "%s"',
                $this->getFrom()
            ));
        }

        return $contents;
    }

    /**
     * Get the source file
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * Set the source file
     */
    public function setFrom(string $from): self
    {
        $this->from = $from;

        return $this;
    }
}
