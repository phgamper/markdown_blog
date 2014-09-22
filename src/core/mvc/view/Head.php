<?php 

class Head
{
    private $config;
    private $sheets = array();
    
    private static $instance = null;
    
    private function __construct()
    {
        $ini = parse_ini_file(CONFIG_DIR.'general.ini', true);
        
        if(isset($ini['head']))
        {
            $this->config = $ini['head']; 
        } 
    }
    
    private function __clone()
    {
    }
    
    /**
     * returns the instance created by its first invoke.
     *
     * @return Head
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
     * link a CSS to the style sheet list
     *
     * @param $href path to css file
     * @param $rel  type of how to link the css
     */
    public function link($href, $rel = 'stylesheet')
    {
        $this->sheets[$href] = $rel;
    }
    
    /**
     * empty the style sheets list
     */
    public function flush()
    {
        $this->sheets = array();
    }

    /**
     * generate the head as a HTML string 
     *
     * @return string to print
     */
    public function toString()
    {
        $css = '';
        $site = isset($_GET['module']) ? ' - '. $_GET['module']: '';
        $title = '<title>'.$this->config['title'].$site.'</title>';
        $meta = '<meta charset="utf-8">'.$title.'<meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="description" content=""><meta name="author" content="">';
        foreach ($this->sheets as $href => $rel)
        {
            $css .= '<link href="'.$href.'" rel="'.$rel.'">';
        }  
        if(isset($this->config['favicon']))
        {
            $css .= '<link href="'.$this->config['favicon'].'" rel="icon" type="image/png">';
        }        
        $string = '<head>'.$meta.$css.'</head>';        
        return $string; 
    }
}

?>