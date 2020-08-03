<?php
namespace Naneau\FileGen;

/**
 * Describes access rights for a file or directory
 */
abstract class AccessRights extends Node
{
    /**
     * The mode
     *
     * @var int
     */
    private $mode;

    public function __construct(string $name, int $mode)
    {
        parent::__construct($name);

        $this->setMode($mode);
    }

    /**
     * Get the mode (as an int)
     */
    public function getMode(): int
    {
        return $this->mode;
    }

    /**
     * Set the mode (as an int)
     */
    public function setMode(int $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Has a mode been set?
     */
    public function hasMode(): bool
    {
        return $this->mode !== null;
    }
}
