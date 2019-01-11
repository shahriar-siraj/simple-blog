<?php

class DB
{

    private static $host = DB_HOST;
    private static $db_name = DB_NAME;
    private static $username = DB_USER;
    private static $password = DB_PASSWORD;

 
    /**
     * Establishes Database Connection
     *
     * @return mixed
     */
    public static function getConnection()
    {
        $conn = null;
 
        try
        {
            $conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db_name, self::$username, self::$password);
            $conn->exec("set names utf8");
        }
        catch(PDOException $exception)
        {
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $conn;
    }
    
    /**
     * Runs SQL Query and
     * Returns the result
     *
     * @param string $sql
     * @return mixed
     */
    public static function query($sql)
    {
        $db = self::getConnection();
    
        // prepare query statement
        $stmt = $db->prepare($sql);
    
        // execute query
        $stmt->execute();

        $num = $stmt->rowCount();
    
        // check if more than 0 record found
        $arr = array();
        
        if ($num > 0)
        {
        
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                array_push($arr, $row);
            }
        }

        return $arr;
    }
    
    /**
     * Runs SQL Query and
     * Returns boolean or result
     *
     * @param string $sql
     * @param mixed $data
     * @param boolean $return_bool
     * @return mixed
     */
    public static function queryWithData($sql, $data, $return_bool = true)
    {
        $db = self::getConnection();
    
        // prepare query statement
        $stmt = $db->prepare($sql);
    
        $params = array();
        
        // sanitize
        foreach ($data as $key => $value) 
        {
            if ($value) 
            {
                $params[$key] = htmlspecialchars(strip_tags($value));
            }
        }

        if ($return_bool)
        {
            if ($stmt->execute($params))
            {
                return true;
            }
    
            return false;
        }
        else 
        {
            // execute query
            $stmt->execute($params);

            $num = $stmt->rowCount();
        
            // check if more than 0 record found
            $arr = array();
            
            if ($num > 0)
            {
            
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    array_push($arr, $row);
                }
            }

            return $arr;
        }
        
    }
}
?>