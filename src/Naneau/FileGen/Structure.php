<?php
namespace Naneau\FileGen;

use Naneau\FileGen\File\Contents as FileContents;

use Naneau\FileGen\Parameter\Set as ParameterSet;

use Naneau\FileGen\Structure\Exception as StructureException;

/**
 * A structure
 */
class Structure extends Directory
{
    /**
     * The parameter definition
     *
     * @var ParameterSet
     */
    private $parameterDefinition;

    /**
     * Constructor
     */
    public function __construct(int $mode = 0666)
    {
        // Although the root node (Structure) is a directory, it does not  have
        // a "name", relative to the root
        parent::__construct('', $mode);

        // Initialize the parameter definition
        $this->setParameterDefinition(new ParameterSet);
    }

    /**
     * Add a file
     *
     * @param FileContents|string $contents
     */
    public function file(string $name, $contents = '', int $mode = 0666): self
    {
        // Create the file itself
        $file = new File(basename($name), $contents, $mode);

        $parent = $this->parentDirectory($name);
        assert($parent instanceof Directory);

        $parent->addChild($file);

        return $this;
    }

    /**
     * Add a directory
     */
    public function directory(string $name, int $mode = 0777): self
    {
        // Create the file itself
        $directory = new Directory(basename($name), $mode);

        $parent = $this->parentDirectory($name);
        assert($parent instanceof Directory);

        $parent->addChild($directory);

        return $this;
    }

    /**
     * Create a symlink
     */
    public function link(string $from, string $to): self
    {
        // Create the file itself
        $link = new SymLink($from, basename($to));

        $parent = $this->parentDirectory($to);
        assert($parent instanceof Directory);

        $parent->addChild($link);

        return $this;
    }

    /**
     * Add a parameter
     */
    public function parameter(string $name, string $description = null): self
    {
        $this->getParameterDefinition()->add($name, $description);

        return $this;
    }

    /**
     * Get the parameter definition
     */
    public function getParameterDefinition(): ParameterSet
    {
        return $this->parameterDefinition;
    }

    /**
     * Set the parameter definition
     */
    public function setParameterDefinition(ParameterSet $parameterDefinition): self
    {
        $this->parameterDefinition = $parameterDefinition;

        return $this;
    }

    /**
     * Create (and add) a parent directory for a path
     *
     * @return self|Node
     */
    private function parentDirectory(string $name)
    {
        // Parent path
        $parentPath = dirname(trim($name, DIRECTORY_SEPARATOR));

        // There is no parent path (parent directory is the root)
        if ($parentPath === '.') {
            return $this;
        }

        // Directories to add
        $directories = explode(DIRECTORY_SEPARATOR, $parentPath);

        $parent = $this;
        // Going through directories, highest level first
        foreach ($directories as $directory) {
            if ($parent->hasChild($directory)) {
                // If the parent already has a child by the name of $directory

                // Fetch the current child by that name
                $childDir = $parent->getChild($directory);

                // Make sure we get a directory back (it may be a file)
                if (!($childDir instanceof Directory)) {
                    throw new StructureException(sprintf(
                        'Trying to add directory where there is a file already: "%s"',
                        $parent->getFullName() . DIRECTORY_SEPARATOR . $directory
                    ));
                }
            } else {
                // Child directory does not exist yet, create a new one
                $childDir = new Directory($directory);

                // Add the child to the old parent
                $parent->addChild($childDir);
            }

            // Next directory with the new parent
            $parent = $childDir;
        }

        return $parent;
    }
}
