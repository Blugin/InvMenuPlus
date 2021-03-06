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

use blugin\lib\invmenu\plus\inventory\slot\SlotTransactionEvent;
use blugin\lib\invmenu\plus\inventory\SlotPagingInventory;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use pocketmine\item\Item;

class SwitcingPageSlot extends ImmutableSlot{
    /** @var int */
    protected $pageNumber;

    public function __construct(Item $item, int $page){
        parent::__construct($item);
        $this->pageNumber = $page;
    }

    public function handleTransaction(SlotTransactionEvent $event) : InvMenuTransactionResult{
        $inventory = $event->getInventory();
        if(!$inventory instanceof SlotPagingInventory){
            throw new \RuntimeException("SwitcingPageSlot is only available in SlotPagingInventory.");
        }

        $inventory->setPageNumber($this->pageNumber);
        return $event->discard();
    }
}