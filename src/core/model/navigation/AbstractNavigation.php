<?php

abstract class AbstractNavigation
{
    protected $items = array();
    
    public abstract function getView();

    public function getItems()
    {
        return $this->items;
    }
}

?>
