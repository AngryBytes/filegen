<?php

namespace Naneau\FileGen\Parameter;

use Naneau\FileGen\Exception as FileGenException;
use Iterator;

/**
 * A set of parameters
 *
 * @phpstan-implements Iterator<Parameter>
 */
class Set implements Iterator
{
    /**
     * Position of the iteration
     */
    private int $position = 0;

    /**
     * Parameters
     *
     * @var Parameter[]
     */
    private array $parameters = [];

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
     *
     * @throws FileGenException If the parameter can't be found.
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
