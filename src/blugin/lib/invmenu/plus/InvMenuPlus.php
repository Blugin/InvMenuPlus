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

namespace blugin\lib\invmenu\plus;

use muqsit\invmenu\inventory\InvMenuInventory;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\InvMenuHandler;
use muqsit\invmenu\metadata\MenuMetadata;
use pocketmine\inventory\Inventory;

class InvMenuPlus extends InvMenu{
    /** @return InvMenuPlus */
    public static function create(string $identifier, ...$args) : InvMenu{
        return new InvMenuPlus($type = InvMenuHandler::getMenuType($identifier), ...$args);
    }

    public function __construct(MenuMetadata $type, ?string $inventoryClass = null, ?Inventory $custom_inventory = null){
        if(!InvMenuHandler::isRegistered()){
            throw new \InvalidStateException("Tried creating menu before calling " . InvMenuHandler::class . "::register()");
        }

        $this->type = $type;
        if($inventoryClass !== null && is_a($inventoryClass, InvMenuInventory::class, true)){
            $this->inventory = new $inventoryClass($type);
        }else{
            $this->inventory = $this->type->createInventory();
        }
        $this->setInventory($custom_inventory);
    }
}
