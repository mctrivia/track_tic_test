<?php

namespace tracktik\electronics;

use Exception;

class ElectronicItem
{

    private float $price=0;
    private string $type;
    private bool $wired=true;
    /// instead of using php docs for these primitive types to specify the types actually specified them in PHP
    /// original code wired was defined as string but test text makes obvious this is supposed to be a boolean

    /** @var array<ElectronicItem>  */
    private array $extras=[];
    /// php does not allow typing arrays so need to use php docs

    /**
     * Returns the price of the item
     * @param bool $includeExtras - if set to false will return only the base item's price.  otherwise extras will be added
     * @return float
     */
    public function getPrice(bool $includeExtras=true):float
    {
        //get my price
        $total=$this->price;
        if (!$includeExtras) return $total; //if not asking for extras then return now

        //add price of any extras
        foreach ($this->extras as $extra)
        {
            $total+=$extra->getPrice();        }
        return $total;
        ///added the ability to get the base item price or combined price of all.
    }

    /**
     * Returns the type of the item
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * returns if wired or not
     * @return bool
     */
    function getWired(): bool
    {
        return $this->wired;
    }

    /**
     * Sets the price of the item
     * @param float $price
     */
    function setPrice(float $price): void
    {
        ///thought about not allowing negative prices but since discounts may be a desired option I left as is
        $this->price = $price;
    }

    /**
     * Sets the type of the item.
     * @param string $type
     */
    function setType(string $type):void
    {
        $this->type = $type;
    }

    /**
     * Sets if wired or not
     * @param bool $wired
     */
    function setWired(bool $wired):void
    {
        $this->wired = $wired;
    }

    /**
     * Returns the max number of extras that can be added to an item
     * @return int
     */
    function maxExtras():int
    {
        return 0;
    }

    /**
     * Adds an extra to the item
     * @param ElectronicItem $item
     * @throws Exception when over max allowed
     */
    function addExtra(ElectronicItem $item): void
    {
        if (count($this->extras)>=$this->maxExtras()) throw new Exception("No more extras can be added to this item");
        $this->extras[]=$item;
    }

    /**
     * Gets a list of all extras
     * @return array<ElectronicItem>
     */
    function getExtras(): array
    {
        return $this->extras;
    }
}