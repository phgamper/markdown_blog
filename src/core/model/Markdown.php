<?php

class Markdown
{
    public $path;
    public $count = 0;
    
    public function __construct($path)
    {
        $this->path = $path;
        Head::getInstance()->link(CSS_DIR.'markdown.css');
    }
    
    public function getList($start = 0, $limit = null)
    {
        $list = array();
        $files = ScanDir::getFilesOfType($this->path, '.md');
        $this->count = count($files);        
        rsort($files);
        $limit = is_null($limit) ? count($files) : $limit;
        
        for ($i = $start; $i < count($files) && $i - $start < $limit; $i++)
        {
            $list[] = $this->parse($this->path.$files[$i]);
        }
        return $list;
    }
    
    public function get()
    {
        return $this->parse($this->path);
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