<?php
namespace Naneau\FileGen\Test\Parameter;

use Naneau\FileGen\Parameter\Set as ParameterSet;

class SetTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test add/get
     */
    public function testGet(): void
    {
        $set = new ParameterSet;
        $set
            ->add('foo', 'bar')
            ->add('baz', 'qux');


        $foo = $set->get('foo');
        $this->assertEquals('bar', $foo->getDescription());

        $baz = $set->get('baz');
        $this->assertEquals('qux', $baz->getDescription());
    }

    /**
     * Test get of param that's absent
     */
    public function testGetNonExisting(): void
    {
        $this->expectException(\Naneau\FileGen\Exception::class);

        $set = new ParameterSet;
        $set->add('foo', 'bar');

        $set->get('baz');
    }
}
