<?php
namespace Naneau\FileGen\Test\Generator;

use Naneau\FileGen\Generator;

use \RecursiveDirectoryIterator;
use \RecursiveIteratorIterator;
use \FilesystemIterator;

/**
 * Base class for tests, sets up virtual file system
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Root dir for tests
     *
     * @var string
     */
    private $rootDir;

    /**
     * Set Up test
     */
    public function setUp(): void
    {
        $dir = sys_get_temp_dir() . '/naneau-file-gen-tests';

        if (file_exists($dir)) {
            self::deleteDir($dir);
        }
        mkdir($dir);

        $this->setRootDir($dir);
    }

    public function tearDown(): void
    {
        self::deleteDir($this->getRootDir());
    }

    /**
     * Get the creation root
     */
    public function getRootDir(): string
    {
        return $this->rootDir;
    }

    /**
     * Set the creation root
     */
    public function setRootDir(string $rootDir): self
    {
        $this->rootDir = $rootDir;

        return $this;
    }

    /**
     * Create a new generator
     *
     * @param  string[] $parameters
     * @return Generator
     */
    protected function createGenerator(array $parameters = []): Generator
    {
        return new Generator($this->getRootDir(), $parameters);
    }

    /**
     * Get the tests directory root path
     */
    protected function getTestsRoot(): string
    {
        $path = realpath(__DIR__ . '/../../../../');
        assert($path !== false);

        return $path;
    }

    /**
     * Delete a directory
     */
    private static function deleteDir(string $dir): void
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isFile() || $file->isLink()) {
                unlink($file);
            } else {
                rmdir($file);
            }
        }

        rmdir($dir);
    }
}
