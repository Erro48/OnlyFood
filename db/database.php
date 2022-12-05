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

    public function getUserPosts($username){
        $stmt = $this->db->prepare("
        SELECT * FROM posts p
        JOIN recipes r on r.recipeId=p.recipe
        JOIN users u on u.username=p.owner
        WHERE p.owner=?
        ORDER BY p.date DESC
        LIMIT 15;
        ");

        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProfileInfo($username){
        $stmt = $this->db->prepare("
        SELECT u.username, u.name, u.surname, u.profilePic, 
            (SELECT Count(*) FROM follows WHERE follower='carlo61') as numFollowing,
	        (SELECT Count(*) FROM follows WHERE followed='carlo61') as numFollower
        FROM users u
        WHERE u.username=?");

        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC)[0];
    }

    public function getMostUsedIngredients($username){
        $stmt = $this->db->prepare("
        SELECT c.ingredient as name, i.color, count(*) as timesUsed  
        FROM posts p
        JOIN recipes r on r.recipeId=p.recipe
        JOIN compositions c on c.recipe=r.recipeId
        JOIN ingredients i on c.ingredient=i.name
        WHERE p.owner=?
        GROUP BY c.ingredient, i.name
        ORDER BY timesUsed DESC
        LIMIT 3");

        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>