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
        SELECT *
        FROM posts p, recipes r, users u, follows f
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

    public function getLikesByPost($postId){
        $stmt = $this->db->prepare("
        SELECT COUNT(*) AS likes
        FROM likes l
        WHERE l.post = ?");
        $stmt->bind_param('i', $postId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCommentsByPost($postId){
        $stmt = $this->db->prepare("
        SELECT COUNT(*) AS comments
        FROM comments c
        WHERE c.postId = ?");
        $stmt->bind_param('i', $postId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function isUserRegistered($user) {
        if (!isset($user)) {
            throw new Exception('Variable $user is not defined');
        }
        $stmt = $this->db->prepare("SELECT username FROM users WHERE username = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        return count($result->fetch_all(MYSQLI_ASSOC)) > 0;
    }

    public function getUserPassword($user) {
        if (!isset($user)) {
            throw new Exception('Variable $user is not defined');
        }
        $stmt = $this->db->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC)['password'];
    }

}
?>