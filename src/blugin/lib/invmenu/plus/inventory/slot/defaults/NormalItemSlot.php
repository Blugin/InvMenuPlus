<?php

/*
 *
 *  ____  _             _         _____
 * | __ )| |_   _  __ _(_)_ __   |_   _|__  __ _ _ __ ___
 * |  _ \| | | | |/ _` | | '_ \    | |/ _ \/ _` | '_ ` _ \
 * | |_) | | |_| | (_| | | | | |   | |  __/ (_| | | | | | |
 * |____/|_|\__,_|\__, |_|_| |_|   |_|\___|\__,_|_| |_| |_|
 *                |___/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author  Blugin team
 * @link    https://github.com/Blugin
 * @license https://www.gnu.org/licenses/lgpl-3.0 LGPL-3.0 License
 *
 *   (\ /)
 *  ( . .) ♥
 *  c(")(")
 */

declare(strict_types=1);

namespace blugin\lib\invmenu\plus\inventory\slot\defaults;

use blugin\lib\invmenu\plus\inventory\slot\ISlot;
use blugin\lib\invmenu\plus\inventory\slot\SlotTransactionEvent;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;

class NormalItemSlot implements ISlot{
    protected Item $item;

    public function __construct(Item $item){
        $this->item = $item;
    }

    public function handleTransaction(SlotTransactionEvent $event) : InvMenuTransactionResult{
        return $event->continue();
    }

    public function getItem() : ?Item{
        return $this->item;
    }

    public function setItem(?Item $item) : void{
        $this->item = $item ?? ItemFactory::air();
    }
}
