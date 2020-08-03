<?php
namespace Naneau\FileGen;

use Naneau\FileGen\File\Contents as ContentGenerator;
use Naneau\FileGen\File\Contents\StringBased as StringContents;

use \InvalidArgumentException;

/**
 * A file
 */
class File extends AccessRights
{
    /**
     * Contents of the file
     *
     * @var ContentGenerator
     */
    private $contentGenerator;

    /**
     * Constructor
     *
     * @param ContentGenerator|string $contents
     */
    public function __construct(string $name, $contents = '', int $mode = 0666)
    {
        parent::__construct($name, $mode);

        $this->setContentGenerator($contents);
    }

    /**
     * Get the contents as a string
     *
     * @param string[] $parameters
     */
    public function getContents(array $parameters = []): string
    {
        // Merge incoming parameters with that of the content generator if the
        // content generator is parameterized
        if ($this->getContentGenerator() instanceof Parameterized) {
            $this->getContentGenerator()->setParameters(array_merge(
                $this->getContentGenerator()->getParameters(),
                $parameters
            ));
        }

        return $this->getContentGenerator()->getContents();
    }

    /**
     * Get the content generator
     */
    public function getContentGenerator(): ContentGenerator
    {
        return $this->contentGenerator;
    }

    /**
     * Set the content generator
     *
     * @param  ContentGenerator|string $contentGenerator
     */
    public function setContentGenerator($contentGenerator): self
    {
        if (is_string($contentGenerator)) {
            $this->contentGenerator = new StringContents($contentGenerator);
        } elseif ($contentGenerator instanceof ContentGenerator) {
            $this->contentGenerator = $contentGenerator;
        } else {
            throw new InvalidArgumentException(
                'Content generator needs to be string or instance of Naneau\FileGen\File\Contents'
            );
        }

        return $this;
    }
}
