<?php
/**
 * src/pocketmine/block/Fence.php
 *
 * @package default
 */


/*
 *
 *  _                       _           _ __  __ _
 * (_)                     (_)         | |  \/  (_)
 *  _ _ __ ___   __ _  __ _ _  ___ __ _| | \  / |_ _ __   ___
 * | | '_ ` _ \ / _` |/ _` | |/ __/ _` | | |\/| | | '_ \ / _ \
 * | | | | | | | (_| | (_| | | (_| (_| | | |  | | | | | |  __/
 * |_|_| |_| |_|\__,_|\__, |_|\___\__,_|_|_|  |_|_|_| |_|\___|
 *                     __/ |
 *                    |___/
 *
 * This program is a third party build by ImagicalMine.
 *
 * PocketMine is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author ImagicalMine Team
 * @link http://forums.imagicalcorp.ml/
 *
 *
*/

namespace pocketmine\block;

use pocketmine\item\Tool;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;

class Fence extends Transparent
{
    const FENCE_OAK = 0;
    const FENCE_SPRUCE = 1;
    const FENCE_BIRCH = 2;
    const FENCE_JUNGLE = 3;
    const FENCE_ACACIA = 4;
    const FENCE_DARKOAK = 5;

    protected $id = self::FENCE;

    /**
     *
     * @param unknown $meta (optional)
     */
    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }


    /**
     *
     * @return unknown
     */
    public function getHardness()
    {
        return 2;
    }


    /**
     *
     * @return unknown
     */
    public function getToolType()
    {
        return Tool::TYPE_AXE;
    }


    /**
     *
     * @return unknown
     */
    public function getName()
    {
        static $names = [
            self::FENCE_OAK => "Oak Fence",
            self::FENCE_SPRUCE => "Spruce Fence",
            self::FENCE_BIRCH => "Birch Fence",
            self::FENCE_JUNGLE => "Jungle Fence",
            self::FENCE_ACACIA => "Acacia Fence",
            self::FENCE_DARKOAK => "Dark Oak Fence",
            "",
            ""
        ];
        return $names[$this->meta & 0x07];
    }


    /**
     *
     * @return unknown
     */
    protected function recalculateBoundingBox()
    {
        $north = $this->canConnect($this->getSide(Vector3::SIDE_NORTH));
        $south = $this->canConnect($this->getSide(Vector3::SIDE_SOUTH));
        $west = $this->canConnect($this->getSide(Vector3::SIDE_WEST));
        $east = $this->canConnect($this->getSide(Vector3::SIDE_EAST));

        $n = $north ? 0 : 0.375;
        $s = $south ? 1 : 0.625;
        $w = $west ? 0 : 0.375;
        $e = $east ? 1 : 0.625;

        return new AxisAlignedBB(
            $this->x + $w,
            $this->y,
            $this->z + $n,
            $this->x + $e,
            $this->y + 1.5,
            $this->z + $s
        );
    }


    /**
     *
     * @param Block   $block
     * @return unknown
     */
    public function canConnect(Block $block)
    {
        return ($block instanceof Fence or $block instanceof FenceGate) ? true : $block->isSolid() and !$block->isTransparent();
    }
}
