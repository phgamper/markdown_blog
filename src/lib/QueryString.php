<?php

class QueryString
{

    public static function remove($search)
    {
        $query = $_SERVER['QUERY_STRING'];
        
        if (isset($_GET[$search]))
        {
            $query = str_replace('&' . $search . '=' . $_GET[$search], '', $query);
            $query = str_replace($search . '=' . $_GET[$search], '', $query);
            $query = substr($query, -1) == '&' ? $query = substr($query, 0, -1) : $query;
        }
        return $query;
    }

    public static function removeAll(array $search)
    {
        $query = $_SERVER['QUERY_STRING'];
        
        foreach ($search as $value)
        {
            if (isset($_GET[$value]))
            {
                $query = str_replace('&' . $value . '=' . $_GET[$value], '', $query);
                $query = str_replace($value . '=' . $_GET[$value], '', $query);
                $query = substr($query, -1) == '&' ? $query = substr($query, 0, -1) : $query;
            }
        }
        return $query;
    }
}

?>