<?php
namespace tracktik\electronics;
require __DIR__.'/vendor/autoload.php';


/*___      _
 / __| ___| |_ _  _ _ __
 \__ \/ -_)  _| || | '_ \
 |___/\___|\__|\_,_| .__/
                   |_|
Lets create the customers hypothetical cart of items
 */

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

//create cart
$cart=new ElectronicItems([
    $tv1,$tv2,$microwave,$console
]);





/*_____     _    _       __  __      _
 |_   _|_ _| |__| |___  |  \/  |__ _| |_____ _ _
   | |/ _` | '_ \ / -_) | |\/| / _` | / / -_) '_|
   |_|\__,_|_.__/_\___| |_|  |_\__,_|_\_\___|_|
Quick and easy fixed width table maker.
 */

//print desired results
const COLUMN_WIDTH_LEFT=20;
const COLUMN_WIDTH_RIGHT=12;

/**
 * Draws a line of the table
 * @param string $type
 * @param float $price
 */
function drawLine(string $type,float $price): void {
    echo (str_pad($type,COLUMN_WIDTH_LEFT," ")) .   //print left column
        "|" .
        str_pad("$".number_format($price,2),COLUMN_WIDTH_RIGHT," ",STR_PAD_LEFT) .  //print right column
        "\n";
}

/**
 * Draw table horizontal divider
 */
function drawDivider():void {
    echo str_pad("",COLUMN_WIDTH_LEFT,"-") . "+" . str_pad("",COLUMN_WIDTH_RIGHT,"-")."\n";
}

/**
 * Draws the table header
 */
function drawHeader():void {
    echo str_pad("Item Type",COLUMN_WIDTH_LEFT," ",STR_PAD_BOTH) .
        "|" .
        str_pad("Price",COLUMN_WIDTH_RIGHT," ",STR_PAD_BOTH)."\n";
}

/* ___    _
  / _ \  / |
 | (_) | | |
  \__\_\ |_|
Sort the parts by price and output total.  Did not say to output the sorted list, but I decided to print an ascii receipt.
Returning HTML would have been easier but this way it makes easier to see results in terminal
 */

//draw header
echo "\n\n\nQuestion 1 Results:\n";
drawHeader();
drawDivider();

//draw item list
$sorted=$cart->getSortedItems(ElectronicItems::SORT_PRICE);
foreach ($sorted as $item) drawLine($item->getType(),$item->getPrice());

//draw total
drawDivider();
drawLine("Total:",$cart->getTotal());



/* ___    ___
  / _ \  |_  )
 | (_) |  / /
  \__\_\ /___|
List how much console and controllers cost.
*/
echo "\n\n\nQuestion 2 Results:\n";

//draw header
drawHeader();
drawDivider();

//get requested item
$item=$cart->getItemsByType(Console::type)[0];

//draw the item
drawLine($item->getType(),$item->getPrice(false));

//draw extras
$extras=$item->getExtras();
foreach ($extras as $extra) drawLine($extra->getType().($extra->getWired()?" wired":" wireless"),$extra->getPrice());

//draw total
drawDivider();
drawLine("Total:",$item->getPrice());
echo "\n\n\n";

