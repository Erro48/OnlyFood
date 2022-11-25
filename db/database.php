<?php
class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port){
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }        
    }

    public function getPostsByUser($username){
        $stmt = $this->db->prepare("
        SELECT * FROM posts p, recipes r, users u, follows f
        WHERE f.follower = ?
        AND p.owner = f.followed
        AND r.recipeId = p.recipe
        AND p.owner = u.username
        ORDER BY p.date DESC
        LIMIT 15");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

}
?>