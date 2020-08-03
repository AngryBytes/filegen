<?php
namespace Naneau\FileGen;

/**
 * Description of symlink
 */
class SymLink extends Node
{
    /**
     * The endpoint of the link
     *
     * @var string
     */
    private $endpoint;

    public function __construct(string $from, string $to)
    {
        parent::__construct($to);

        $this->setEndpoint($from);
    }

    /**
     * Get the endpoint of the link
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * Set the endpoint of the link
     */
    public function setEndpoint(string $endpoint): self
    {
        $this->endpoint = $endpoint;

        return $this;
    }
}
