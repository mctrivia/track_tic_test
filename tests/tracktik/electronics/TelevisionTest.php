<?php

namespace tracktik\electronics;
require __DIR__.'/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class TelevisionTest extends TestCase
{
    private Television $subject;

    public function setUp():void
    {
        //create a test subject
        $this->subject=new Television();
    }

    public function testConstants()
    {
        //check no one has accidentally changed the constants
        $this->assertSame(Television::type,"Television");
    }

    public function test__construct()
    {
        //check type in constructor during setup took
        $this->assertSame($this->subject->getType(),Television::type);
    }

    public function testMaxExtrasInvalidType()
    {
        //try adding an invalid type
        $this->expectError();
        /** @noinspection PhpUnhandledExceptionInspection */
        /** @noinspection PhpParamsInspection */
        $this->subject->addExtra(false);
    }

    public function testMaxExtras()
    {
        //check we can add 10000 items if we want(too time-consuming to test infinity)
        for ($i=0;$i<10000;$i++)
        {
            $this->subject->addExtra(new Controller());
            $this->assertSame(count($this->subject->getExtras()),$i+1);
        }
    }

    public function testGetPrice()
    {
        //when extras are added to an item there price should change accordingly
        $this->subject->setPrice(599.99);
        $this->assertSame($this->subject->getPrice(),599.99);
        $remote=new Controller();
        $remote->setPrice(0.99);
        $this->subject->addExtra($remote);
        $this->assertSame($this->subject->getPrice(),600.98);

        //check we can still get the original item price
        $this->assertSame($this->subject->getPrice(false),599.99);
    }

    public function testSetType()
    {
        //check we are not able to change subclass type
        $this->expectExceptionMessage("Changing class type is not allowed");
        $this->subject->setType("foo");
    }


}
