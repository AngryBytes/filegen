<?php
namespace Naneau\FileGen;

use Naneau\FileGen\Exception as FileGenException;

use \Iterator;

/**
 * A directory, that can contain children (other directories, files, symlinks)
 *
 * @phpstan-implements Iterator<Node>
 */
class Directory extends AccessRights implements Iterator
{
    /**
     * Position of the iteration
     *
     * @var int
     */
    private $position = 0;

    /**
     * Child nodes
     *
     * @var Node[]
     */
    private $children = [];

    public function __construct(string $name, int $mode = 0777)
    {
        parent::__construct($name, $mode);
    }

    /**
     * Scan the child nodes for a path
     *
     * When given a path like `foo/bar/baz`, it will see if directory `foo`
     * exists, it has a child directory node `bar`, which should have a child
     * node `baz`
     *
     * Will return either the found child node, or boolean false
     *
     * @return Node|bool
     */
    public function scan(string $path)
    {
        // Start scanning at the root (this dir)
        $node = $this;

        foreach (explode(DIRECTORY_SEPARATOR, $path) as $item) {
            // For every child dir (starting at lowest level)

            // Can't find children if $node is not a directory
            if (!($node instanceof Directory)) {
                return false;
            }

            // If the current node doesn't have the item, $path doesn't exist (fully)
            if (!$node->hasChild($item)) {
                return false;
            }

            // New parent node
            $node = $node->getChild($item);
        }

        return $node;
    }

    /**
     * Get the child nodes
     *
     * @return Node[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set the child nodes
     *
     * @param  Node[]    $children
     */
    public function setChildren(array $children): self
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Add a child
     */
    public function addChild(Node $child): self
    {
        $child->setParent($this);

        $this->children[] = $child;

        return $this;
    }

    /**
     * Does a child with name $name exist?
     */
    public function hasChild(string $name): bool
    {
        foreach ($this as $node) {
            if ($node->getName() === $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get a child with name $name
     */
    public function getChild(string $name): Node
    {
        foreach ($this as $node) {
            if ($node->getName() === $name) {
                return $node;
            }
        }

        throw new FileGenException(sprintf(
            'Node "%s" not found',
            $name
        ));
    }

    /**
     * Rewind iterator
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * Get current node
     */
    public function current(): Node
    {
        return $this->children[$this->position];
    }

    /**
     * Get current key
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * Go to next position
     */
    public function next(): void
    {
        ++$this->position;
    }

    /**
     * Is the iterator in a valid position?
     */
    public function valid(): bool
    {
        return isset($this->children[$this->position]);
    }
}
