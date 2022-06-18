<?php

namespace tracktik\electronics;
require __DIR__.'/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class ElectronicItemsTest extends TestCase
{
    private ElectronicItems $subject;

    public function setUp():void
    {
        //console
        $console=new Console();
        $console->setPrice(699.99);
        for ($i=0;$i<2;$i++)
        {
            //add remote controllers
            $remote=new Controller();
            $remote->setWired(false);
            $remote->setPrice(49.99);
            $console->addExtra($remote);

            //add wired controllers
            $wired=new Controller();
            $wired->setWired(true);
            $wired->setPrice(19.99);
            $console->addExtra($wired);
        }

        //tv1
        $tv1=new Television();
        $tv1->setPrice(399.99);
        for ($i=0;$i<2;$i++) {
            $remote = new Controller();
            $remote->setWired(false);
            $tv1->addExtra($remote);
        }

        //tv2
        $tv2=new Television();
        $tv2->setPrice(499.99);
        $remote = new Controller();
        $remote->setWired(false);
        $tv2->addExtra($remote);

        //microwave
        $microwave=new Microwave();
        $microwave->setPrice(99.99);

        $this->subject=new ElectronicItems([
            $tv1,$tv2,$microwave,$console
        ]);
    }

    public function test__construct()
    {
        //already constructed in setup so just check that items add are present
        $this->assertSame($this->subject->getItemCount(),4);
    }

    public function testGetSortedItems()
    {
        //prices used for check because they are unique per item

        //sort by default
        $sorted = $this->subject->getSortedItems();
        $this->assertSame($sorted[0]->getPrice(), 99.99);    //microwave
        $this->assertSame($sorted[1]->getPrice(), 399.99);   //tv1
        $this->assertSame($sorted[2]->getPrice(), 499.99);   //tv2
        $this->assertSame($sorted[3]->getPrice(), 839.95);   //console

        //sort by none
        $sorted = $this->subject->getSortedItems(ElectronicItems::SORT_NONE);
        $this->assertSame($sorted[0]->getPrice(), 399.99);   //tv1
        $this->assertSame($sorted[1]->getPrice(), 499.99);   //tv2
        $this->assertSame($sorted[2]->getPrice(), 99.99);    //microwave
        $this->assertSame($sorted[3]->getPrice(), 839.95);   //console

        //sort by none reversed
        $sorted = $this->subject->getSortedItems(ElectronicItems::SORT_NONE | ElectronicItems::SORT_DESC);
        $this->assertSame($sorted[0]->getPrice(), 839.95);   //console
        $this->assertSame($sorted[1]->getPrice(), 99.99);    //microwave
        $this->assertSame($sorted[2]->getPrice(), 499.99);   //tv2
        $this->assertSame($sorted[3]->getPrice(), 399.99);   //tv1

        //sort by price asc
        $sorted = $this->subject->getSortedItems(ElectronicItems::SORT_PRICE | ElectronicItems::SORT_ASC);
        $this->assertSame($sorted[0]->getPrice(), 99.99);    //microwave
        $this->assertSame($sorted[1]->getPrice(), 399.99);   //tv1
        $this->assertSame($sorted[2]->getPrice(), 499.99);   //tv2
        $this->assertSame($sorted[3]->getPrice(), 839.95);   //console

        //sort by price desc
        $sorted = $this->subject->getSortedItems(ElectronicItems::SORT_PRICE | ElectronicItems::SORT_DESC);
        $this->assertSame($sorted[0]->getPrice(), 839.95);   //console
        $this->assertSame($sorted[1]->getPrice(), 499.99);   //tv2
        $this->assertSame($sorted[2]->getPrice(), 399.99);   //tv1
        $this->assertSame($sorted[3]->getPrice(), 99.99);    //microwave

        //sort by type
        $sorted = $this->subject->getSortedItems(ElectronicItems::SORT_TYPE);
        $this->assertSame($sorted[0]->getPrice(), 839.95);   //console
        $this->assertSame($sorted[1]->getPrice(), 99.99);    //microwave
        $this->assertSame($sorted[2]->getPrice(), 399.99);   //tv1
        $this->assertSame($sorted[3]->getPrice(), 499.99);   //tv2

        //sort by type desc
        $sorted = $this->subject->getSortedItems(ElectronicItems::SORT_TYPE | ElectronicItems::SORT_DESC);
        $this->assertSame($sorted[0]->getPrice(), 499.99);   //tv2
        $this->assertSame($sorted[1]->getPrice(), 399.99);   //tv1
        $this->assertSame($sorted[2]->getPrice(), 99.99);    //microwave
        $this->assertSame($sorted[3]->getPrice(), 839.95);   //console

        //add an extra microwave and make sure sort returns both
        $microwave = new Microwave();
        $microwave->setPrice(99.99);
        $this->subject->addItem($microwave);

        //sort price asc
        $sorted = $this->subject->getSortedItems(ElectronicItems::SORT_PRICE | ElectronicItems::SORT_ASC);
        $this->assertSame($sorted[0]->getPrice(), 99.99);    //microwave
        $this->assertSame($sorted[1]->getPrice(), 99.99);    //microwave
        $this->assertSame($sorted[2]->getPrice(), 399.99);   //tv1
        $this->assertSame($sorted[3]->getPrice(), 499.99);   //tv2
        $this->assertSame($sorted[4]->getPrice(), 839.95);   //console

        //sort by type
        $sorted = $this->subject->getSortedItems(ElectronicItems::SORT_TYPE);
        $this->assertSame($sorted[0]->getPrice(), 839.95);   //console
        $this->assertSame($sorted[1]->getPrice(), 99.99);    //microwave
        $this->assertSame($sorted[2]->getPrice(), 99.99);    //microwave
        $this->assertSame($sorted[3]->getPrice(), 399.99);   //tv1
        $this->assertSame($sorted[4]->getPrice(), 499.99);   //tv2

    }

    public function testGetSortedItemsInvalidType()
    {
        //sort by invalid type production
        assert_options(ASSERT_ACTIVE, 0);
        $sorted=$this->subject->getSortedItems(-1);
        $this->assertSame($sorted[0]->getPrice(),399.99);   //tv1
        $this->assertSame($sorted[1]->getPrice(),499.99);   //tv2
        $this->assertSame($sorted[2]->getPrice(),99.99);    //microwave
        $this->assertSame($sorted[3]->getPrice(),839.95);   //console

        //sort by invalid type debug
        assert_options(ASSERT_ACTIVE, 1);
        $this->expectError();
        $sorted=$this->subject->getSortedItems(-1);
    }

    public function testAddItem()
    {
        //add an extra microwave and make sure sort returns both
        $microwave=new Microwave();
        $microwave->setPrice(99.99);
        $this->subject->addItem($microwave);
        $this->assertSame($this->subject->getItemCount(),5);

    }

    public function testGetItemsByType()
    {
        //check returns empty array if ask for something that doesn't exist
        $items=$this->subject->getItemsByType("Car");
        $this->assertSame(count($items),0);

        //check returns correct items when asked for something that does exist
        $items=$this->subject->getItemsByType(Television::type);
        $this->assertSame(count($items),2);
        $this->assertSame($items[0]->getPrice()+$items[1]->getPrice(),899.98);  //make sure 1 of each without caring about order
    }
}
