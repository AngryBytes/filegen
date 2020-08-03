<?php
namespace Naneau\FileGen\File\Contents;

use Naneau\FileGen\File\Contents as FileContents;
use Naneau\FileGen\Parameterized;

use Twig\TemplateWrapper as TwigTemplate;

/**
 * Use twig to get the contents for a file
 */
class Twig implements FileContents, Parameterized
{
    /**
     * The twig template
     *
     * @var TwigTemplate
     */
    private $template;

    /**
     * The parameters
     *
     * @var string[]
     */
    private $parameters;

    /**
     * Constructor
     *
     * @param  string[] $parameters
     */
    public function __construct(TwigTemplate $template, array $parameters = [])
    {
        $this
            ->setTemplate($template)
            ->setParameters($parameters);
    }

    /**
     * Get the contents
     */
    public function getContents(): string
    {
        return $this->getTemplate()->render($this->getParameters());
    }

    /**
     * Get the template
     */
    public function getTemplate(): TwigTemplate
    {
        return $this->template;
    }

    /**
     * Set the template
     */
    public function setTemplate(TwigTemplate $template): self
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get the parameters
     *
     * @return string[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Set the parameters
     *
     * @param string[] $parameters
     */
    public function setParameters(array $parameters): Parameterized
    {
        $this->parameters = $parameters;

        return $this;
    }
}
