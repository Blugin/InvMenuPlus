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

namespace blugin\lib\invmenu\plus\inventory\slot;

use blugin\lib\invmenu\plus\inventory\SlotBasedInventory;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\item\Item;
use pocketmine\Player;

class SlotTransactionEvent{
    /** @var InvMenuTransaction */
    protected $transaction;

    /** @var Player */
    protected $player;

    /** @var SlotChangeAction */
    protected $action;

    /** @var SlotBasedInventory */
    protected $inventory;

    /** @var InvMenu */
    protected $menu;

    /** @var int */
    private $windowId;

    /** @var \Closure|null */
    private $closeListener = null;

    public function __construct(InvMenuTransaction $transaction, SlotBasedInventory $inventory, InvMenu $menu){
        $this->transaction = $transaction;
        $this->player = $transaction->getPlayer();
        $this->action = $transaction->getAction();
        $this->inventory = $inventory;
        $this->menu = $menu;

        $this->windowId = $this->player->getWindowId($inventory);
    }

    public function getTransaction() : InvMenuTransaction{
        return $this->transaction;
    }

    public function getPlayer() : Player{
        return $this->player;
    }

    public function getAction() : SlotChangeAction{
        return $this->action;
    }

    public function getInventory() : SlotBasedInventory{
        return $this->inventory;
    }

    public function getMenu() : InvMenu{
        return $this->menu;
    }

    public function getSlot() : int{
        return $this->action->getSlot();
    }

    public function getSourceItem() : Item{
        return $this->action->getSourceItem();
    }

    public function getTargetItem() : Item{
        return $this->action->getTargetItem();
    }

    public function getWindowId() : int{
        return $this->windowId;
    }

    public function continue() : InvMenuTransactionResult{
        return $this->transaction->continue();
    }

    public function discard() : InvMenuTransactionResult{
        return $this->transaction->discard();
    }

    public function getCloseListener() : ?\Closure{
        return $this->closeListener;
    }

    public function setCloseListener(?\Closure $closure) : void{
        $this->closeListener = $closure;
    }
}
