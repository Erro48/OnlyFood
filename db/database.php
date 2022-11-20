<?php
class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port){
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }        
    }

    public function getPostsByUser($userId){
        $stmt = $this->db->prepare("SELECT * FROM posts p, recipes r, users u WHERE r.recipeId = p.recipe AND p.owner = u.username");      //da cambiare ovviamente
        //$stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

}
?>