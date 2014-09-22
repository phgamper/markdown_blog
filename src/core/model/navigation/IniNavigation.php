<?php

class IniNavigation extends AbstractNavigation
{

    public function __construct($ini)
    {
        $this->items = $this->init($ini);
    }

    public function getView()
    {
        return new IniNavigationView($this);
    }

    protected function init($ini)
    {
        $items = array();
        $ini = parse_ini_file($ini, true);
        
        foreach ($ini as $key => $value)
        {
            $items[$key] = array();
            $items[$key]['dropdown'] = array();
            
            foreach ($value as $k => $v)
            {
                if (!is_numeric($k) && $k == "name")
                {
                    $items[$key][$k] = $v;
                }
                else if (!is_numeric($k) && $k == "path")
                {
                    $items[$key][$k] = $v;
                }
                else
                {
                    $items[$key][$key][$k] = $v;
                }
            }
        }
        
        return $items;
    }
}

?>
