<?php

class Markdown
{
    public $count = 0;
    
    public function __construct()
    {
        Head::getInstance()->link(CSS_DIR.'markdown.css');
    }
    
    public function getList($path, $start = 0, $limit = null)
    {
        $list = array();
        $files = ScanDir::getFilesOfType($path, '.md');
        $this->count = count($files);        
        rsort($files);
        $limit = is_null($limit) ? count($files) : $limit;
        
        for ($i = $start; $i < count($files) && $i - $start < $limit; $i++)
        {
            $list[] = $this->parse($path.$files[$i]);
        }
        return $list;
    }
    
    public function get($markdown)
    {
               
    }
    
    public function parse($file)
    {
        $string = '';
        $fh = fopen($file, 'r');
        
        if ($fh)
        {
            $string = Parsedown::instance()->parse(fread($fh, filesize($file)));
        }
        else
        {
            self::add(new Error('Can not open '.$file, 'Markdown::parse("'.$file.'")'));
        }
        
        return $string;
    }
}

?>