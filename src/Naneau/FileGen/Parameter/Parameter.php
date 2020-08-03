<?php
namespace Naneau\FileGen\Parameter;

/**
 * A single parameter
 */
class Parameter
{
    /**
     * Name of the parameter
     *
     * @var string
     */
    private $name;

    /**
     * Human readable description
     *
     * @var string
     */
    private $description;

    /**
     * The default value
     *
     * @var mixed
     */
    private $defaultValue;

    /**
     * Is there a default value?
     *
     * This is checked outside of the $defaultValue property, as `null` is a
     * valid default value
     *
     * @var bool
     */
    private $hasDefaultValue = false;

    /**
     * Constructor
     */
    public function __construct(string $name, ?string $description = null)
    {
        $this->setName($name);

        // Set the description, or use the name as a fallback description if none given
        $this->setDescription($description ?? $name);
    }

    /**
     * Get the name/key of the parameter
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the name/key of the parameter
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the description in human readable form
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the description in human readable form
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the default value
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Set the default value
     *
     * @param mixed $defaultValue
     */
    public function setDefaultValue($defaultValue): self
    {
        $this->setHasDefaultValue(true);

        $this->defaultValue = $defaultValue;

        return $this;
    }

    /**
     * Does this parameter have a default value?
     */
    public function hasDefaultValue(): bool
    {
        return $this->hasDefaultValue;
    }

    /**
     * Set the default value flag
     */
    private function setHasDefaultValue(bool $hasDefaultValue = true): self
    {
        $this->hasDefaultValue = $hasDefaultValue;

        return $this;
    }
}
