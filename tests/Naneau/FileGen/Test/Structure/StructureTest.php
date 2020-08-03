<?php
namespace Naneau\FileGen\Test\Structure;

use Naneau\FileGen\Structure;
use Naneau\FileGen\Directory;
use Naneau\FileGen\File;
use Naneau\FileGen\SymLink;

/**
 * Test structure generation
 */
class StructureTest extends \PHPUnit\Framework\TestCase
{
    public function testStructure(): void
    {
        // Note leading slashes in some
        $structure = new Structure;
        $structure
            ->directory('foo')
            ->directory('/bar')
            ->file('foo/bar', 'bar contents')
            ->file('foo/baz', 'baz contents')
            ->link('/from/this/file', 'to/this')
            ->link('/from/another/file', '/to/that');

        self::assertInstanceOf(
            Directory::class,
            $structure->scan('foo')
        );
        self::assertInstanceOf(
            Directory::class,
            $structure->scan('bar')
        );
        self::assertInstanceOf(
            File::class,
            $structure->scan('foo/bar')
        );
        self::assertInstanceOf(
            SymLink::class,
            $structure->scan('to/this')
        );
        self::assertInstanceOf(
            SymLink::class,
            $structure->scan('to/that')
        );
    }

    /**
     * test invalid structure
     */
    public function testDirectoryFileMix(): void
    {
        $this->expectException(\Naneau\FileGen\Structure\Exception::class);

        // Can't add file under a node that's a file already
        $structure = new Structure;
        $structure
            ->file('foo', 'bar contents')
            ->file('foo/baz', 'baz contents');
    }

    public function testParameterDefinition(): void
    {
        // Note leading slashes in some
        $structure = new Structure;
        $structure
            // Throw in a file and directory
            ->directory('foo')
            ->file('bar')

            // Simple parameters
            ->parameter('foo', 'The foo parameter')
            ->parameter('bar', 'The bar parameter');

        self::assertInstanceOf(
            Directory::class,
            $structure->scan('foo')
        );
        self::assertInstanceOf(
            File::class,
            $structure->scan('bar')
        );

        $structure->getParameterDefinition()->get('foo');
        $structure->getParameterDefinition()->get('bar');
    }
}
