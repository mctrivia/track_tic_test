<?php

namespace tracktik\electronics;
require __DIR__.'/../../../vendor/autoload.php';

use Error;
use PHPUnit\Framework\TestCase;

class ConsoleTest extends TestCase
{
    private Console $subject;

    public function setUp():void
    {
        //create a test subject
        $this->subject=new Console();
    }

    public function testConstants()
    {
        //check no one has accidentally changed the constants
        $this->assertSame(Console::type,"Console");
    }

    public function test__construct()
    {
        //check type in constructor during setup took
        $this->assertSame($this->subject->getType(),Console::type);
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
        //check we can add 4 items
        for ($i=0;$i<4;$i++)
        {
            $this->subject->addExtra(new Controller());
            $this->assertSame(count($this->subject->getExtras()),$i+1);
        }

        //check we can't add a 5th item
        $this->expectExceptionMessage("No more extras can be added to this item");
        $this->subject->addExtra(new Controller());
    }

    public function testGetPrice()
    {
        //when extras are added to an item there price should change accordingly
        $this->subject->setPrice(499.99);
        $this->assertSame($this->subject->getPrice(),499.99);
        $remote=new Controller();
        $remote->setPrice(49.99);
        $this->subject->addExtra($remote);
        $this->assertSame($this->subject->getPrice(),549.98);
        $remote->setPrice(49.99);
        $this->subject->addExtra($remote);
        $this->assertSame($this->subject->getPrice(),599.97);

        //check we can still get the original item price
        $this->assertSame($this->subject->getPrice(false),499.99);
    }

    public function testSetType()
    {
        //check we are not able to change subclass type
        $this->expectExceptionMessage("Changing class type is not allowed");
        $this->subject->setType("foo");
    }


}
