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

namespace blugin\lib\invmenu\plus\inventory;

use muqsit\invmenu\metadata\MenuMetadata;

class SlotPagingInventory extends SlotBasedInventory{
    /** @var SlotBasedItemArray[] */
    protected array $pages = [];

    protected int $pageNumber;

    public function __construct(MenuMetadata $menu_metadata){
        parent::__construct($menu_metadata);
        $this->pages = [$this->getSlotList()];
        $this->pageNumber = 0;
    }

    /** @return SlotBasedItemArray[] */
    public function getPages() : array{
        return $this->pages;
    }

    /** @param SlotBasedItemArray[] $pages */
    public function setPages(array $pages, int $pageNumber) : void{
        $this->pages = array_values($pages);
        $this->pageNumber = -1;
        $this->setPageNumber($pageNumber);
    }

    public function addPage(SlotBasedItemArray $page) : void{
        $this->pages[] = $page;
    }

    public function removePage(int $pageNumber) : void{
        unset($this->pages[$pageNumber]);
    }

    public function getPage(int $pageNumber) : ?SlotBasedItemArray{
        return $this->pages[$pageNumber] ?? null;
    }

    public function setPage(int $pageNumber, SlotBasedItemArray $page) : void{
        if(!isset($this->pages[$pageNumber])){
            $this->addPage($page);
        }else{
            $this->pages[$pageNumber] = $page;
        }
    }

    public function getPageNumber() : int{
        return $this->pageNumber;
    }

    public function setPageNumber(int $pageNumber) : void{
        if($this->pageNumber === $pageNumber)
            return;

        if(!isset($this->pages[$pageNumber]))
            throw new \InvalidArgumentException("$pageNumber is invalid page number");

        $this->pageNumber = $pageNumber;
        $this->slots = $this->pages[$pageNumber];
        foreach($this->getViewers() as $viewer){
            $viewer->getNetworkSession()->getInvManager()->syncContents($this);
        }
    }
}
