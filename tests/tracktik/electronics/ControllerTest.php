<?php

namespace tracktik\electronics;
require __DIR__.'/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class ControllerTest extends TestCase
{
    private Controller $subject;

    public function setUp():void
    {
        //create a test subject
        $this->subject=new Controller();
    }

    public function testConstants()
    {
        //check no one has accidentally changed the constants
        $this->assertSame(Controller::type,"Controller");
    }

    public function test__construct()
    {
        //check type in constructor during setup took
        $this->assertSame($this->subject->getType(),Controller::type);
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
