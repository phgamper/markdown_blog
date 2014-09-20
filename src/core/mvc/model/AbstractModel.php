<?php

abstract class AbstractModel implements IModel
{
    private static $METHOD_ERROR = array('getList' => 'Listing','get' => 'Accessing');
    private static $METHOD_SUCCESS = array('getList' => 'listed','get' => 'retrieved');
    protected $entity;
    protected $logging = true;

    public abstract function getDefaultView();

    public function getList()
    {
        
    }

    public function get($id)
    {
    }

    public function setLogging($v)
    {
        $this->logging = $v;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    protected function abort($method, $reason, $e = null)
    {
        if ($this->logging)
        {
            $e = new Error(self::$METHOD_ERROR[$method] . ' ' . $this->entity . ' aborted: ' . $reason, 
                get_class($this) . '::' . $method . '()', $e);
            Logger::getInstance()->add($e);
        }
        return -1;
    }

    protected function warning($method, $reason, $e = null)
    {
        if ($this->logging)
        {
            $e = new Warning($reason, get_class($this) . '::' . $method . '()', $e);
            Logger::getInstance()->add($e);
        }
        return -1;
    }

    protected function success($method, $id, $e = null)
    {
        if ($this->logging)
        {
            $s = new Success('Entry #' . $id . ' has been successfully ' . self::$METHOD_SUCCESS[$method], 
                get_class($this) . '::' . $method . '()', $e);
            Logger::getInstance()->add($s);
        }
        return 1;
    }
}

?>
