<?php

namespace tracktik\electronics;
///I assume you have company policy on name spaces.  Since I don't know it just guessed at one that would fit.

class ElectronicItems
{

    /**
     * Sort Types Available
     */
    const SORT_NONE=0;
    const SORT_PRICE=2;
    const SORT_TYPE=4;

    /**
     * Sort Orders Available
     */
    const SORT_ASC=0;
    const SORT_DESC=1;


    /** @var array<ElectronicItem> */
    private array $items = array();

    /**
     * @param array<ElectronicItem> $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * Returns the number of items in the object
     * @return int
     */
    public function getItemCount(): int {
        return count($this->items);
    }

    /**
     * Returns the total price of all items
     * @return float
     */
    public function getTotal(): float {
        $total=0;
        foreach ($this->items as $item) $total+=$item->getPrice();
        return $total;
    }

    /**
     * Adds an ElectronicItem to the object
     * @param ElectronicItem $item
     */
    public function addItem(ElectronicItem $item):void
    {
        $this->items[]=$item;
    }

    /**
     * Returns the items depending on the sorting type requested
     * @param int $type
     * @return array<ElectronicItem>
     */
    public function getSortedItems(int $type=self::SORT_PRICE): array
    {

        //calculate desired sort type and order
        if (($type<0)||($type>=6))  //make sure to change range if more sort types added
        {
            $type=0;    //for production environment default to ascending by time added
            assert(false,"Passing invalid sort type to getSortedItems");
        }
        $sortType=2*(int)floor($type/2);    //split out the sort type
        $sortReverse=($type%2==self::SORT_DESC);  //split out if reversing sort

        //sort data
        $copy=$this->items; //copy data so we can maintain order data was added
        if ($sortType>self::SORT_NONE)
        {
            //get the sort function we will use
            $func = match ($sortType)
            {
                self::SORT_PRICE => function(ElectronicItem $a,ElectronicItem $b) {return $a->getPrice() <=> $b->getPrice();},
                self::SORT_TYPE => function(ElectronicItem $a,ElectronicItem $b) {return strcmp($a->getType(),$b->getType());}
            };

            //sort copy of data
            usort($copy,$func);
        }

        //see if we should return in reverse
        if ($sortReverse) $copy=array_reverse($copy);

        return $copy;
        /// original function would have collisions if there were more than 1 item with the same price
        /// original documentation said there should be more than 1 sort method and had an unused, undefined type variable, so I defined it and made functional
        /// added override of invalid sort types and an assert so during debugging an error would come up if an invalid sort type was used.
        /// could have thrown an exception, but it did not seem necessary and this way we don't need to catch the exception.
    }

    /**
     * Returns a list of ElectronicItems of the type provided
     * @param string $type
     * @return array<ElectronicItem>
     */
    public function getItemsByType(string $type): array
    {
        $result=[];
        foreach ($this->items as $item) {
            if ($item->getType() == $type) $result[]=$item;
        }
        return $result;

        /// array_filter maintains original keys and that did not seem a desirable effect since we do not have any functions to utilize these keys
        /// original function was accessing private variables.
        /// original function docs said it returned an array, but it returned false if an unknown type
        /// assumed docs are correct and changed, so it returns an empty array if invalid type
    }
}