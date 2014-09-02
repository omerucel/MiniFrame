<?php

namespace MiniFrame\Di;

class DiImplTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DiImpl
     */
    protected $dependencyInjection;

    protected function setUp()
    {
        $this->dependencyInjection = new DiImpl();
    }

    public function testGetDefaultNull()
    {
        $this->assertNull($this->dependencyInjection->get('not found'));
    }

    public function testGetShared()
    {
        $this->dependencyInjection->set('fake', function () {
            return microtime();
        }, true);

        $time1 = $this->dependencyInjection->get('fake');
        $time2 = $this->dependencyInjection->get('fake');
        $this->assertEquals($time1, $time2);
    }

    public function testGet()
    {
        $this->dependencyInjection->set('fake', function () {
            return microtime();
        });

        $time1 = $this->dependencyInjection->get('fake');
        $time2 = $this->dependencyInjection->get('fake');
        $this->assertNotEquals($time1, $time2);
    }

    public function testSetNotCallable()
    {
        $this->dependencyInjection->set('value', 10);
        $this->assertEquals(10, $this->dependencyInjection->get('value'));
    }
}
