<?php

namespace tracktik\electronics;
require __DIR__.'/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class MicrowaveTest extends TestCase
{
    private Microwave $subject;

    public function setUp():void
    {
        //create a test subject
        $this->subject=new Microwave();
    }

    public function testConstants()
    {
        //check no one has accidentally changed the constants
        $this->assertSame(Microwave::type,"Microwave");
    }

    public function test__construct()
    {
        //check type in constructor during setup took
        $this->assertSame($this->subject->getType(),Microwave::type);
    }

    public function testMaxExtras()
    {
        //check we can't add any item
        $this->expectExceptionMessage("No more extras can be added to this item");
        $this->subject->addExtra(new Controller());
    }

    public function testSetType()
    {
        //check we are not able to change subclass type
        $this->expectExceptionMessage("Changing class type is not allowed");
        $this->subject->setType("foo");
    }


}
