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

use muqsit\invmenu\InvMenuEventHandler;
use muqsit\invmenu\InvMenuHandler;
use muqsit\invmenu\session\PlayerManager;
use pocketmine\plugin\Plugin;

class InvMenuPlusHandler{
    public static function register(Plugin $plugin) : void{
        if(!InvMenuHandler::isRegistered()){
            InvMenuHandler::register($plugin);
        }else{
            $plugin->getServer()->getPluginManager()->registerEvents(new InvMenuEventHandler($plugin), $plugin);
        }

        foreach($plugin->getServer()->getOnlinePlayers() as $player){
            PlayerManager::destroy($player);
            PlayerManager::create($player);
        }
        $plugin->getServer()->getPluginManager()->registerEvents(InvMenuPlusEventHandler::getInstance(), $plugin);
    }
}
