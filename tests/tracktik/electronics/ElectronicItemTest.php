<?php

namespace tracktik\electronics;
require __DIR__.'/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class ElectronicItemTest extends TestCase
{
    private ElectronicItem $subject;

    public function setUp():void
    {
        //create a test subject
        $this->subject=new ElectronicItem();
    }

    public function testSetGetPrice()
    {
        //set the price and check it is reflected
        $this->subject->setPrice(5.51);
        $this->assertSame($this->subject->getPrice(),5.51);

        //set to free and see it is allowed
        $this->subject->setPrice(0);
        $this->assertSame($this->subject->getPrice(),0.0);

        //set to negative value and see it is allowed
        $this->subject->setPrice(-9.96);
        $this->assertSame($this->subject->getPrice(),-9.96);

        //try setting to an invalid type and make sure it throws an error
        $this->expectError();
        $this->subject->setPrice("gh");
    }

    public function testSetGetType()
    {
        //set type and check it can be retrieved
        $this->subject->setType("Car");
        $this->assertSame($this->subject->getType(),"Car");
    }

    public function testMaxExtras()
    {
        //check default type can't have extras
        $this->assertSame($this->subject->maxExtras(),0);
    }

    public function testSetGetWired()
    {
        //set true and check it can be retrieved
        $this->subject->setWired(true);
        $this->assertSame($this->subject->getWired(),true);

        //set false and check it can be retrieved
        $this->subject->setWired(false);
        $this->assertSame($this->subject->getWired(),false);
    }

    public function testAddExtra()
    {
        //check we can't add any item
        $this->expectExceptionMessage("No more extras can be added to this item");
        $this->subject->addExtra(new Controller());
    }
}
