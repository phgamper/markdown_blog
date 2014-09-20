<?php

class ListModel implements IListableModel
{
    protected $list;

    public function __construct(array $list, $entity)
    {
        $this->list = $list;
        $this->entity = $entity;
    }
    
    public function getEntity()
    {
        return $this->entity;
    }

    public function getEntities()
    {
        return $this->list;
    }

    public function getList()
    {
        return $this->list;
    }
}    

?>