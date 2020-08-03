<?php
namespace Naneau\FileGen;

use Naneau\FileGen\Generator\Exception as GeneratorException;
use Naneau\FileGen\Generator\Exception\NodeExists as NodeExistsException;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException as FilesystemIOException;

use \InvalidArgumentException;

/**
 * The generator takes directory structures and actually creates them on disk
 */
class Generator implements Parameterized
{
    /**
     * Root of the generation
     *
     * @var string
     */
    private $root;

    /**
     * The parameters
     *
     * @var string[]
     */
    private $parameters;

    /**
     * The symfony filesystem
     *
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * Constructor
     *
     * @param string[] $parameters
     */
    public function __construct(string $root, array $parameters = [])
    {
        $this
            ->setRoot($root)
            ->setParameters($parameters)
            ->setFilesystem(new Filesystem);
    }

    /**
     * Generate a Structure on disk
     */
    public function generate(Structure $structure): bool
    {
        foreach ($structure as $node) {
            $this->createNode($node);
        }

        return true;
    }

    /**
     * Get the root directory
     */
    public function getRoot(): string
    {
        return $this->root;
    }

    /**
     * Set the root directory
     */
    public function setRoot(string $root): self
    {
        $this->root = $root;

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
     * @return self
     */
    public function setParameters(array $parameters): Parameterized
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get the file system
     */
    public function getFilesystem(): Filesystem
    {
        return $this->fileSystem;
    }

    /**
     * Set the file system
     */
    public function setFilesystem(Filesystem $fileSystem): self
    {
        $this->fileSystem = $fileSystem;

        return $this;
    }

    /**
     * Create a node
     *
     * @param Node $node
     */
    private function createNode(Node $node): void
    {
        // See if it exists
        if (file_exists($this->getNodePath($node))) {
            throw new NodeExistsException(sprintf(
                'Node "%s" exists, can not create it',
                $this->getNodePath($node)
            ));
        }

        switch (true) {
            case $node instanceof File:
                $this->createFile($node);
                break;
            case $node instanceof SymLink:
                $this->createLink($node);
                break;
            case $node instanceof Directory:
                $this->createDirectory($node);
                break;
            default:
                throw new InvalidArgumentException('Invalid node type');
        }
    }

    /**
     * Create a file
     */
    private function createFile(File $file): self
    {
        // Full path to the file
        $fullPath = $this->getNodePath($file);

        // Generate contents
        $contents = $file->getContents($this->getParameters());

        try {
            $this->getFilesystem()->dumpFile($fullPath, $contents);
            if ($file->hasMode()) {
                $this->getFilesystem()->chmod($fullPath, $file->getMode());
            }
        } catch (FilesystemIOException $filesystemException) {
            throw new GeneratorException(
                sprintf(
                    'Could not generate file "%s"',
                    $fullPath
                ),
                0,
                $filesystemException
            );
        }

        return $this;
    }

    /**
     * Create a directory
     */
    private function createDirectory(Directory $directory): self
    {
        $fullPath = $this->getNodePath($directory);

        // Try to make it
        try {
            if ($directory->hasMode()) {
                $this->getFilesystem()->mkdir($fullPath, $directory->getMode());
            } else {
                $this->getFilesystem()->mkdir($fullPath);
            }
        } catch (FilesystemIOException $filesystemException) {
            throw new GeneratorException(
                sprintf(
                    'Could not generate directory "%s"',
                    $this->getNodePath($directory)
                ),
                0,
                $filesystemException
            );
        }

        // Recurse child nodes
        foreach ($directory as $node) {
            $this->createNode($node);
        }

        return $this;
    }

    /**
     * Create a symlink
     */
    private function createLink(SymLink $link): self
    {
        $fullToPath = $this->getNodePath($link);
        $fullFromPath = $link->getEndpoint();

        // Endpoint needs to exist
        if (!file_exists($fullFromPath)) {
            throw new GeneratorException(sprintf(
                'Can not create symlink "%s", endpoint "%s" does not exist',
                $fullToPath,
                $fullFromPath
            ));
        }

        // Try to link it
        try {
            $this->getFilesystem()->symlink($fullFromPath, $fullToPath);
        } catch (FilesystemIOException $filesystemException) {
            throw new GeneratorException(
                sprintf(
                    'Can not create symlink "%s", with endpoint "%s"',
                    $fullToPath,
                    $fullFromPath
                ),
                0,
                $filesystemException
            );
        }

        return $this;
    }

    /**
     * Get the full path to a node, including the root path
     *
     * @see getRoot()
     */
    private function getNodePath(Node $node): string
    {
        return $this->getRoot()
            . DIRECTORY_SEPARATOR
            . trim($node->getFullName(DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR);
    }
}
