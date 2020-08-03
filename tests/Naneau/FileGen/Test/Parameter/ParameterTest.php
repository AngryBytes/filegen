<?php
namespace Naneau\FileGen\Test\Parameter;

use Naneau\FileGen\Parameter\Parameter;

class ParameterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test description constructor
     */
    public function testConstructDescription(): void
    {
        $param = new Parameter('foo', 'bar');
        self::assertEquals(
            'foo',
            $param->getName()
        );
        self::assertEquals(
            'bar',
            $param->getDescription()
        );
    }

    /**
     * no description given test
     */
    public function testConstructWithoutDescription(): void
    {
        $param = new Parameter('foo');
        self::assertEquals('foo', $param->getName());
        self::assertEquals('foo', $param->getDescription());
    }

    /**
     * No default value
     */
    public function testNoDefaultValue(): void
    {
        $param = new Parameter('foo');
        self::assertFalse($param->hasDefaultValue());
    }

    /**
     * Default value
     */
    public function testDefaultValue(): void
    {
        $param = new Parameter('foo');
        $param->setDefaultValue('bar');

        self::assertTrue($param->hasDefaultValue());
        self::assertEquals('bar', $param->getDefaultValue());
    }

    /**
     * Default value `null`
     */
    public function testNullValue(): void
    {
        $param = new Parameter('foo');
        $param->setDefaultValue(null);

        self::assertTrue($param->hasDefaultValue());
        self::assertEquals(null, $param->getDefaultValue());
    }
}
