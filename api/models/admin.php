<?php

class Admin
{
    /**
     * Table Name
     *
     * @var string
     */
    private static $table_name = "admins";

    /**
     * Admin Properties
     */
    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;
    public $updated_at;

    /**
     * Gets a single admin
     *
     * @param int $id
     * @return mixed
     */
    public static function get($id)
    {
        $sql = "select b.*, a.name as admin_name, a.email as admin_email 
                from " . self::$table_name . " b, admins a 
                where b.admin_id = a.id and b.id=". $id;

        return DB::query($sql);
    }
    
    /**
     * Authenticates admin
     *
     * @return mixed
     */
    public function authenticate()
    {
        $sql = "SELECT * FROM " . self::$table_name . " WHERE email = :email";

        return DB::queryWithData($sql, $this, false);
    }

    /**
     * Registers a new admin
     *
     * @return mixed
     */
    public function register()
    {
        $sql = "INSERT INTO
                " . self::$table_name . "
            SET
                name = :name,
                email = :email,
                password = :password,
                created_at = :created_at,
                updated_at = :updated_at";
        
        return DB::queryWithData($sql, $this, false);
    }
}