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

use blugin\lib\invmenu\plus\inventory\slot\SlotTransactionEvent;
use pocketmine\utils\SingletonTrait;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\ContainerClosePacket;

class InvMenuPlusEventHandler implements Listener{
    use SingletonTrait;

    private bool $cancel = true;

    /** @var SlotTransactionEvent[] */
    private array $pendingEvents = [];

    public function pending(SlotTransactionEvent $event) : void{
        if($event->getCloseListener() !== null){
            $this->pendingEvents[] = $event;
        }
    }

    public function removePending(SlotTransactionEvent $event) : void{
        foreach($this->pendingEvents as $key => $pendingEvent){
            if($pendingEvent === $event){
                unset($this->pendingEvents[$key]);
                break;
            }
        }
    }

    /** @priority HIGHEST */
    public function onDataPacketSendEvent(DataPacketSendEvent $event) : void{
        if($this->cancel){
            foreach($event->getPackets() as $packet){
                if($packet instanceof ContainerClosePacket){
                    $event->cancel();
                }
            }
        }
    }

    /**
     * @priority HIGHEST
     * @ignoreCancelled
     */
    public function onDataPacketReceiveEvent(DataPacketReceiveEvent $event) : void{
        $packet = $event->getPacket();
        if($packet instanceof ContainerClosePacket){
            $session = $event->getOrigin();

            $this->cancel = false;
            $session->sendDataPacket($packet);
            $this->cancel = true;

            foreach($this->pendingEvents as $pendingEvent){
                if($pendingEvent->getPlayer() === $session && $pendingEvent->getWindowId() === $packet->windowId){
                    $pendingEvent->getCloseListener()($session->getPlayer());
                    $this->removePending($pendingEvent);
                    break;
                }
            }
        }
    }
}
