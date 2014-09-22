<?php

class ScanDir
{
    private $directories = array();
    private $files = array();
    private $path;

    public function __construct($path = null)
    {
        $this->path = $path == null ? getcwd() : $path;
        self::scanDirectory();
    }

    private function scanDirectory()
    {
        try
        {
            if (is_dir($this->path))
            {
                $scandir = scandir($this->path);
                
                foreach ($scandir as $item)
                {
                    switch (true)
                    {
                        case ($item == '.'):
                        {
                            break;
                        }
                        case ($item == '..'):
                        {
                            break;
                        }
                        case (is_file($this->path . '/' . $item)):
                        {
                            $this->files[] = $item;
                            break;
                        }
                        case (is_dir($this->path . '/' . $item)):
                        {
                            $this->directories[] = $item;
                            break;
                        }
                    }
                }
            }
            else
            {
                // TODO
                Throw new Exception('Directory Not Found!');
            }
        }
        catch (Exception $e)
        {
            // TODO catch exception
        }
    }

    public static function getFilesOfType($path, $mime)
    {
        $scan = new self($path, $mime);
        $files = array();
        foreach($scan->getFiles() as $f)
        {
            if($mime == substr($f, -strlen($mime)))
            {
                $files[] = $f;
            }
        }
        return $files; 
    }
    
    public function getFiles()
    {
        return $this->files;
    }

    public function getDirectories()
    {
        return $this->directories;
    }
}

?>
