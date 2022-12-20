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

    public function getUserInfo($user) {
        if (!isset($user)) {
            throw new Exception('Variable $user is not defined');
        }
        $user = "%" . $user . "%";
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username LIKE ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getUserPassword($user) {
        if (!isset($user)) {
            throw new Exception('Variable $user is not defined');
        }
        $stmt = $this->db->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC)[0]['password'];
    }

    public function getUserByEmail($email) {
        if (!isset($email)) {
            throw new Exception('Variable $email is not defined');
        }
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function userAlreadyRegistered($username, $email = '') {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return count($result->fetch_all(MYSQLI_ASSOC)) > 0;
    }

    public function registerUser($name, $surname, $username, $email, $password, $profile_pic_name, $intolerances = array()) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("INSERT INTO `users` (`username`, `name`, `surname`, `email`, `password`, `profilePic`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $username, $name, $surname, $email, $hashed_password, $profile_pic_name);
        
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        if ($stmt->execute() === true) {
            if (count($intolerances) == 0) {
                return true;
            }

            $query = "INSERT INTO `intolerances` (`user`, `ingredient`) VALUES ";
            $params_types = "";
            $params = array();

            foreach ($intolerances as $ingredient) {
                $query .= '(?, ?),';
                $params_types .= 'ss';
                array_push($params, $username);
                array_push($params, str_replace('_', ' ', $ingredient));
            }
            $query = rtrim($query, ',');

            $stmt_insert = $this->db->prepare($query);
            $stmt_insert->bind_param($params_types, ...$params);

            return $stmt_insert->execute();
        }

        return false;
    }

    public function getMostFrequentIntolerances($n) {
        $query = "SELECT COUNT(ingr.name) as number, ingr.name, ingr.color
                FROM intolerances intol
                JOIN ingredients ingr ON ingr.name = intol.ingredient
                GROUP BY ingr.name
                ORDER BY COUNT(ingr.name) DESC
                LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $n);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getIngredientByPost($postId){
        $stmt = $this->db->prepare("
        SELECT i.color, i.name, c.quantity, m.acronym
        FROM posts p, compositions c, ingredients i, measures m
        WHERE p.postId = ?
        AND c.recipe = p.recipe
        AND c.ingredient = i.name
        AND c.unit = m.name");
        $stmt->bind_param('i', $postId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getIngredients($ingredient) {
        $ingredient = "%" . $ingredient . "%";
        $stmt = $this->db->prepare("SELECT name, color FROM ingredients WHERE name LIKE ?");
        $stmt->bind_param("s", $ingredient);
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
            (SELECT Count(*) FROM follows WHERE follower=?) as numFollowing,
	        (SELECT Count(*) FROM follows WHERE followed=?) as numFollower
        FROM users u
        WHERE u.username=?");

        $stmt->bind_param('sss', $username, $username, $username);
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

    public function getExplorePosts($username, $tags = NULL){
        //var_dump($tags);
        $query = "
        SELECT *
        FROM posts p, recipes r, users u";

        if(isset($tags)){
            $query .= ", belongto b";
        }
        
        $query .= "
        WHERE r.recipeId = p.recipe
        AND p.owner = u.username
        AND p.owner != ?";

        $bindParamString = "s";
        
        if(isset($tags)){
            $query .= " AND b.recipe = p.recipe";
            for($i = 0; $i < count($tags); $i++){
                if($i == 0){
                    $query .= " AND (b.tag = ?";
                } else {
                    $query .= " OR b.tag = ?";
                }
                $bindParamString .= "s";
            }
            $query .= ")";
            $params = array_merge(array($username), $tags);
        }

        $query .= " ORDER BY p.date DESC
                    LIMIT 15";

        /*
        SELECT * FROM posts p, recipes r, users u, belongto b WHERE r.recipeId = p.recipe AND p.owner = u.username AND p.owner != 'carlo61' AND b.recipe = p.recipe AND (b.tag = "launch" OR b.tag = "breakfast") ORDER BY p.date DESC LIMIT 15
        */

        /*var_dump($query);
        var_dump($bindParamString);
        var_dump($params);*/
        $stmt = $this->db->prepare($query);
        if(isset($tags)){
            $stmt->bind_param($bindParamString, ...$params);
        } else {
            $stmt->bind_param($bindParamString, $username);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTags(){
        $stmt = $this->db->prepare("
        SELECT *
        FROM tags
        ORDER BY name");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchTag($name){
        $name = $name."%";
        $stmt = $this->db->prepare("
        SELECT *
        FROM tags
        WHERE name LIKE ?
        ORDER BY name");

        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function updateProfilePic($photo_name) {
        $stmt = $this->db->prepare("UPDATE users SET profilePic= ? WHERE username= ?");
        $stmt->bind_param("ss", $photo_name, $_SESSION["username"]);
        return $stmt->execute();
    }


    public function searchUser($name){
        $username = preg_replace('/(?<!\\\)([%_])/', '\\\$1', $name);
        $name = $name."%";
        $stmt = $this->db->prepare("
        SELECT username, profilePic, name, surname
        FROM users
        WHERE username LIKE ? 
            OR name LIKE ?
            OR surname LIKE ?
            OR CONCAT(name, ' ', surname) LIKE ?
            OR CONCAT(surname, ' ', name) LIKE ?
       ");

        $stmt->bind_param('sssss', $name, $name, $name, $name, $name);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function postAlreadyLikedByUser($username, $postId){
        $stmt = $this->db->prepare("
        SELECT *
        FROM LIKES
        WHERE user = ?
        AND post  = ?");

        $stmt->bind_param('si', $username, $postId);
        $stmt->execute();
        $result = $stmt->get_result();

        return count($result->fetch_all(MYSQLI_ASSOC)) > 0 ? true : false;
    }

    public function likePost($username, $postId){
        if(!postAlreadyLikedByUser($username, $postId)){
            $stmt = $this->db->prepare("
            INSERT INTO likes(user, post)
            VALUES (?, ?)");

            $stmt->bind_param('si', $username, $postId);
            $stmt->execute();
        }
    }

    public function unlikePost($username, $postId){
        if(postAlreadyLikedByUser($username, $postId)){
            $stmt = $this->db->prepare("
            DELETE FROM likes
            WHERE user = ?
            AND post = ?");

            $stmt->bind_param('si', $username, $postId);
            $stmt->execute();
        }
    }
}
?>