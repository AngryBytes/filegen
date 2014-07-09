<?php
/**
 * ParameterTest.php
 *
 * @category        Naneau
 * @package         FileGen
 * @subpackage      Tests
 */

namespace Naneau\FileGen\Test\Parameter;

use Naneau\FileGen\Parameter\Set as ParameterSet;
use Naneau\FileGen\Parameter\Parameter;

use \PHPUnit_Framework_TestCase as PUTestCase;

/**
 * ParameterTest
 *
 * @category        Naneau
 * @package         FileGen
 * @subpackage      Tests
 */
class ParameterTest extends PUTestCase
{
    /**
     * Test description constructor
     *
     * @return void
     **/
    public function testConstructDescription()
    {
        $param = new Parameter('foo', 'bar');
        $this->assertEquals(
            'foo',
            $param->getName()
        );
        $this->assertEquals(
            'bar',
            $param->getDescription()
        );
    }

    /**
     * no description given test
     *
     * @return void
     **/
    public function testConstructWithoutDescription()
    {
        $param = new Parameter('foo');
        $this->assertEquals('foo', $param->getName());
        $this->assertEquals('foo', $param->getDescription());
    }

    /**
     * No default value
     *
     * @return void
     **/
    public function testNoDefaultValue()
    {
        $param = new Parameter('foo');
        $this->assertFalse($param->hasDefaultValue());
    }

    /**
     * Default value
     *
     * @return void
     **/
    public function testDefaultValue()
    {
        $param = new Parameter('foo');
        $param->setDefaultValue('bar');

        $this->assertTrue($param->hasDefaultValue());
        $this->assertEquals('bar', $param->getDefaultValue());
    }

    /**
     * Default value `null`
     *
     * @return void
     **/
    public function testNullValue()
    {
        $param = new Parameter('foo');
        $param->setDefaultValue(null);

        $this->assertTrue($param->hasDefaultValue());
        $this->assertEquals(null, $param->getDefaultValue());
    }
}