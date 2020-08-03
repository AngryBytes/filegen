<?php
namespace Naneau\FileGen\Test\File;

use Naneau\FileGen\Structure;
use Naneau\FileGen\File\Contents\Twig as TwigContents;

use Twig\Loader\FilesystemLoader as TwigFileLoader;
use Twig\Environment as TwigEnvironment;

/**
 * testing twig
 */
class TwigTest extends \Naneau\FileGen\Test\Generator\TestCase
{
    /**
     * Simple render
     */
    public function testRender(): void
    {
        $generator = $this->createGenerator();

        $structure = new Structure;
        $structure->file('foo', new TwigContents(
            $this->createTwig()->load('template_one.twig')
        ));

        $generator->generate($structure);

        // See if structure was generated
        self::assertStringEqualsFile(
            $generator->getRoot() . '/foo',
            "foo bar baz\n" // Twig generates a newline at EOF...
        );
    }

    /**
     * Parameters
     */
    public function testRenderParameters(): void
    {
        $generator = $this->createGenerator();

        $structure = new Structure;
        $structure->file('foo', new TwigContents(
            $this->createTwig()->load('template_two.twig'),
            array(
                'foo' => 'foo',
                'bar' => 'bar',
                'baz' => 'baz'
            )
        ));

        $generator->generate($structure);

        // See if structure was generated
        self::assertStringEqualsFile(
            $generator->getRoot() . '/foo',
            "foo bar baz\n" // Twig generates a newline at EOF...
        );
    }

    /**
     * Test parameters through structure
     */
    public function testStructureParameters(): void
    {
        $structure = new Structure;
        $structure
            ->file('foo', new TwigContents(
                $this->createTwig()->load('template_two.twig')
            ));

        $generator = $this->createGenerator(array(
            'foo' => 'foo',
            'bar' => 'bar',
            'baz' => 'baz'
        ));
        $generator->generate($structure);

        // See if structure was generated
        self::assertStringEqualsFile(
            $generator->getRoot() . '/foo',
            "foo bar baz\n" // Twig generates a newline at EOF...
        );
    }

    /**
     * Parameters
     */
    public function testMissingParameters(): void
    {
        $generator = $this->createGenerator();

        $structure = new Structure;
        $structure->file('foo', new TwigContents(
            $this->createTwig()->load('template_two.twig'),
            array(
                'foo' => 'foo',
                'baz' => 'baz'
            )
        ));

        $generator->generate($structure);

        // See if structure was generated
        self::assertStringEqualsFile(
            $generator->getRoot() . '/foo',
            "foo  baz\n" // Twig generates a newline at EOF...
        );
    }

    /**
     * Create a twig environment
     */
    private function createTwig(): TwigEnvironment
    {
        return new TwigEnvironment(
            new TwigFileLoader($this->getTestsRoot() .  '/templates/'),
            array(
                'cache' => sys_get_temp_dir() . '/filegen-tests-twig-compile'
            )
        );
    }
}
