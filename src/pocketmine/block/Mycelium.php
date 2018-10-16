<?php

/*
 *               _ _
 *         /\   | | |
 *        /  \  | | |_ __ _ _   _
 *       / /\ \ | | __/ _` | | | |
 *      / ____ \| | || (_| | |_| |
 *     /_/    \_|_|\__\__,_|\__, |
 *                           __/ |
 *                          |___/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author TuranicTeam
 * @link https://github.com/TuranicTeam/Altay
 *
 */

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\event\block\BlockSpreadEvent;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\math\Facing;

class Mycelium extends Solid{

	protected $id = self::MYCELIUM;

	public function __construct(){

	}

	public function getName() : string{
		return "Mycelium";
	}

	public function getToolType() : int{
		return BlockToolType::TYPE_SHOVEL;
	}

	public function getHardness() : float{
		return 0.6;
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			ItemFactory::get(Item::DIRT)
		];
	}

	public function ticksRandomly() : bool{
		return true;
	}

	public function onRandomTick() : void{
		//TODO: light levels
		$x = mt_rand($this->x - 1, $this->x + 1);
		$y = mt_rand($this->y - 2, $this->y + 2);
		$z = mt_rand($this->z - 1, $this->z + 1);
		$block = $this->getLevel()->getBlockAt($x, $y, $z);
		if($block->getId() === Block::DIRT){
			if($block->getSide(Facing::UP) instanceof Transparent){
				$ev = new BlockSpreadEvent($block, $this, BlockFactory::get(Block::MYCELIUM));
				$ev->call();
				if(!$ev->isCancelled()){
					$this->getLevel()->setBlock($block, $ev->getNewState());
				}
			}
		}
	}
}
