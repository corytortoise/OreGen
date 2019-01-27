<?php

namespace corytortoise\OreGen;

use pocketmine\plugin\PluginBase;
use pocketmine\block\Block;
use pocketmine\block\BlockFactory;

class Main extends PluginBase {

    public function onEnable() {
        $this->saveDefaultConfig();
        $this->reloadConfig();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }

    /**
     * Returns an array of blocks that should have custom generators.
     * Currently, only three are supported.
     */
    public function getBlocks() {
        return [Block::STONE, Block::COBBLESTONE, Block::OBSIDIAN];
    }

    /**
     * Determines what to generate.
     * @param int $id
     */
    public function getNewBlock($id) {
        $newBlock = $id;
        switch($id) {
            case Block::STONE:
                foreach($this->getConfig()->get("Stone") as $newId => $chance) {
                    if(mt_rand(1, $chance) === 1) {
                        $newBlock = $newId;
                        continue;
                    }
                }
                break;
            case Block::COBBLESTONE:
                foreach($this->getConfig()->get("Cobblestone") as $newId => $chance) {
                    if(mt_rand(1, $chance) === 1) {
                        $newBlock = $newId;
                        continue;
                    }
                }
                break;
            case Block::OBSIDIAN:
                foreach($this->getConfig()->get("Obsidian") as $newId => $chance) {
                    if(mt_rand(1, $chance) === 1) {
                        $newBlock = $newId;
                        continue;
                    }
                }
                break;
        }
        if(!is_int($newBlock)) {
            $newBlock = constant('pocketmine\block\Block::' . (strtoupper($newBlock)));
        }
        return BlockFactory::get($newBlock ?? $id);
    }
}
