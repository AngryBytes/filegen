<?php
namespace Naneau\FileGen\Parameter;

use Naneau\FileGen\Exception as FileGenException;

use \Iterator;

/**
 * A set of parameters
 *
 * @phpstan-implements Iterator<Parameter>
 */
class Set implements Iterator
{
    /**
     * Position of the iteration
     *
     * @var int
     */
    private $position = 0;

    /**
     * Parameters
     *
     * @var Parameter[]
     */
    private $parameters = [];

    /**
     * Add a new parameter
     */
    public function add(string $name, ?string $description = null): self
    {
        $this->parameters[] = new Parameter($name, $description);

        return $this;
    }

    /**
     * Is there a parameter with name $name?
     */
    public function has(string $name): bool
    {
        foreach ($this as $parameter) {
            if ($parameter->getName() === $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get a parameter by name
     */
    public function get(string $name): Parameter
    {
        foreach ($this as $parameter) {
            if ($parameter->getName() === $name) {
                return $parameter;
            }
        }

        throw new FileGenException(sprintf(
            'Can not find parameter "%s"',
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
     * Get current parameter
     */
    public function current(): Parameter
    {
        return $this->parameters[$this->position];
    }

    /**
     * Get current key
     *
     * @return int
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
        return isset($this->parameters[$this->position]);
    }
}
