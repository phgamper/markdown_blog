<?php

final class Autoload
{
    private static $instance = NULL;
    private $classes = array();

    private function __construct()
    {
        self::import(str_replace('//', '/', SRC_DIR));
        self::import(LIB_DIR);
    }

    public static function getInstance()
    {
        if (self::$instance == NULL)
        {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    private function import($path)
    {
        $ScanDir = new ScanDir($path);
        self::addClasses($ScanDir->getFiles(), $path);
        
        foreach ($ScanDir->getDirectories() as $dir)
        {
            self::import($path . $dir . "/");
        }
    }

    private function addClasses($files, $path)
    {
        if ($files)
        {
            foreach ($files as $file)
            {
                if (substr($file, -4) == '.php')
                {
                    $classname = substr($file, 0, -4);
                    $this->classes[$classname] = $path . '/' . $file;
                }
            }
        }
    }

    public function getClasses()
    {
        return $this->classes;
    }
}

?>