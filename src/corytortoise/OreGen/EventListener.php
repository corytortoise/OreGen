<?php

namespace corytortoise\OreGen;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockGrowEvent;
use pocketmine\event\block\BlockFormEvent;

class EventListener implements Listener {

    private $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onBlockGrow(BlockGrowEvent $event) {
        if($event instanceof BlockFormEvent) {
            if(\in_array($event->getNewState()->getId(), $this->plugin->getBlocks())) {
                $event->setCancelled();
                $newblock = $this->plugin->getNewBlock($event->getNewState()->getId());
                $event->getBlock()->getLevel()->setBlock($event->getBlock(), $newblock);
            }
        }
    }

}