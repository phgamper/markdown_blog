<?php 

class Script
{
    private $scripts = array();
    
    private static $instance = null;
    
    private function __construct()
    {
    }
    
    private function __clone()
    {
    }
    
    /**
     * returns the instance created by its first invoke.
     *
     * @return Script
     */
    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
        }
    
        return self::$instance;
    }
    
    /**
     * link a JS to the script list
     *
     * @param $script   path to js file
     */
    public function link($script)
    {
        $this->scripts[] = $script;
    }
    
    /**
     * empty the script list
     */
    public function flush()
    {
        $this->scripts = array();
    }

    /**
     * generate the script list as a HTML string 
     * 
     * @return string to print
     */
    public function toString()
    {
        $js = '<!-- Le javascript -->';
        foreach ($this->scripts as $j)
        {
            $js .= '<script src="'.$j.'"></script>';
        }        
        return $js; 
    }
}

?>