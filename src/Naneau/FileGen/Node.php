<?php
namespace Naneau\FileGen;

/**
 * A node to be created
 */
class Node
{
    /**
     * Name of the node
     *
     * @var string
     */
    private $name;

    /**
     * Parent node
     *
     * @var Node
     */
    private $parent;

    public function __construct(string $name)
    {
        $this->setName($name);
    }

    /**
     * Get the name of the node
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the name of the node
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the name including that of the parent's
     */
    public function getFullName(string $separator = DIRECTORY_SEPARATOR): string
    {
        if ($this->hasParent()) {
            return $this->getParent()->getFullName($separator)
                . $separator
                . $this->getName();
        }

        return $this->getName();
    }

    /**
     * Get the parent node
     */
    public function getParent(): Node
    {
        return $this->parent;
    }

    /**
     * Set the parent node
     */
    public function setParent(Node $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Does this node have a parent?
     */
    public function hasParent(): bool
    {
        return !empty($this->parent);
    }
}
