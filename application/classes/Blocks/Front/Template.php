<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Template extends Blocks_Core
{
    protected function _prepareBlocks()
    { 
        return $this->getData();
    }
     
}   