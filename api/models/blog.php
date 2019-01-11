<?php

class Blog
{
    /**
     * Table Name
     *
     * @var string
     */
    private static $table_name = "blogs";

    /**
     * Blog Properties
     */
    public $id;
    public $admin_id;
    public $title;
    public $content;
    public $created_at;
    public $updated_at;

    /**
     * Gets a single blog
     *
     * @param int $id
     * @return mixed
     */
    public static function get($id)
    {
        $sql = "select b.*, a.name as admin_name, a.email as admin_email 
                from " . self::$table_name . " b, admins a 
                where b.admin_id = a.id and b.id=". $id;

        $blogs = DB::query($sql);

        $blogs = array_map(function ($blog) {
            $blog['short_title'] = strlen($blog['title']) > 20 ? substr($blog['title'], 0, 20)."..." : $blog['title'];
            $blog['short_content'] = strlen($blog['content']) > 50 ? substr($blog['content'], 0, 50)."..." : $blog['content'];

            return $blog;
        }, $blogs);

        return $blogs;
    }
    
    /**
     * Gets all blogs
     *
     * @return mixed
     */
    public static function getAll()
    {
        $sql = "select b.*, a.name as admin_name, a.email as admin_email 
                from " . self::$table_name . " b, admins a 
                where b.admin_id = a.id order by b.id desc";

        $blogs = DB::query($sql);

        $blogs = array_map(function ($blog) {
            $blog['short_title'] = strlen($blog['title']) > 20 ? substr($blog['title'], 0, 20)."..." : $blog['title'];
            $blog['short_content'] = strlen($blog['content']) > 50 ? substr($blog['content'], 0, 50)."..." : $blog['content'];

            return $blog;
        }, $blogs);

        return $blogs;
    }

    /**
     * Creates Blog
     *
     * @return mixed
     */
    public function create()
    {
        $sql = "INSERT INTO " . self::$table_name . " SET admin_id=:admin_id, title=:title, content=:content, created_at=:created_at, updated_at=:updated_at";

        return DB::queryWithData($sql, $this);
    }

    /**
     * Updates Blog
     *
     * @return mixed
     */
    public function update()
    {
        $sql = "UPDATE
                " . self::$table_name . "
            SET
                admin_id = :admin_id,
                title = :title,
                content = :content,
                updated_at = :updated_at
            WHERE
                id = :id";
        
        return DB::queryWithData($sql, $this);
    }
    
    /**
     * Delets Blog
     *
     * @return mixed
     */
    public function delete()
    {
        $sql = "DELETE FROM " . self::$table_name . " WHERE id = :id";
        
        return DB::queryWithData($sql, $this);
    }
}