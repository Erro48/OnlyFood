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

    public function getPostsById($postId){
        $stmt = $this->db->prepare("
        SELECT *
        FROM posts p, recipes r
        WHERE p.recipe = r.recipeId
        AND p.postId = ?");
        $stmt->bind_param('i', $postId);
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

    public function getCommentsCountByPost($postId) {
        $stmt = $this->db->prepare("
        SELECT COUNT(*) AS comments
        FROM comments c
        WHERE c.postId = ?");
        $stmt->bind_param('i', $postId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCommentsByPost($postId) {
        $stmt = $this->db->prepare("
        SELECT *
        FROM comments c, users u
        WHERE c.user = u.username
        AND c.postId = ?
        ORDER BY date DESC");
        $stmt->bind_param('i', $postId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insertComment($username, $postId, $text) {
        $stmt = $this->db->prepare("
        INSERT INTO comments(content, date, user, postId) VALUES
        (?, NOW(), ?, ?);");
        $stmt->bind_param('ssi', $text, $username, $postId);
        $stmt->execute();
        return $stmt->get_result();
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
        global $NUM_FAVOURITE_INGREDIENTS;

        $stmt = $this->db->prepare("
        SELECT c.ingredient as name, i.color, count(*) as timesUsed  
        FROM posts p
        JOIN recipes r on r.recipeId=p.recipe
        JOIN compositions c on c.recipe=r.recipeId
        JOIN ingredients i on c.ingredient=i.name
        WHERE p.owner=?
        GROUP BY c.ingredient, i.name
        ORDER BY timesUsed DESC
        LIMIT ".strval($NUM_FAVOURITE_INGREDIENTS));

        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getExplorePosts($username, $tags = NULL){
        $query = "
        SELECT *
        FROM posts p, recipes r, users u";

        if(isset($tags)){
            $query .= ", belongto b";
        }
        
        $query .= "
        WHERE r.recipeId = p.recipe
        AND p.owner = u.username
        AND p.owner != ?
        AND r.recipeId NOT IN (SELECT c.recipe
                                FROM compositions c, intolerances i
                                WHERE i.user = ?
                                AND c.ingredient = i.ingredient)";

        $bindParamString = "ss";
        
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
            $params = array_merge(array($username, $username), $tags);
        }

        $query .= " ORDER BY p.date DESC
                    LIMIT 15";
        
        $stmt = $this->db->prepare($query);
        if(isset($tags)){
            $stmt->bind_param($bindParamString, ...$params);
        } else {
            $stmt->bind_param($bindParamString, $username, $username);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTags($tag = ""){
        $tag = "%" . $tag . "%";
        $stmt = $this->db->prepare("
        SELECT *
        FROM tags
        WHERE name LIKE ?
        ORDER BY name");
        $stmt->bind_param("s", $tag);
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
        if(!$this->postAlreadyLikedByUser($username, $postId)){
            $stmt = $this->db->prepare("
            INSERT INTO likes(user, post, date)
            VALUES (?, ?, NOW())");

            $stmt->bind_param('si', $username, $postId);
            $stmt->execute();
        }
    }

    public function unlikePost($username, $postId){
        if($this->postAlreadyLikedByUser($username, $postId)){
            $stmt = $this->db->prepare("
            DELETE FROM likes
            WHERE user = ?
            AND post = ?");

            $stmt->bind_param('si', $username, $postId);
            $stmt->execute();
        }
    }

    public function unreadNotificationCount($username){
        $notificationCount = 0;
        $stmt = $this->db->prepare("
                SELECT username as sender, profilePic, f.date
                FROM follows f
                JOIN users u on u.username=f.follower
                WHERE f.followed=? AND f.seen=0 AND f.follower!=?
                ORDER BY f.date DESC");

        $stmt->bind_param('ss', $username, $_SESSION["username"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $notificationCount += count($result->fetch_all(MYSQLI_ASSOC));
        
        $stmt = $this->db->prepare("
                SELECT user as sender, profilePic
                FROM likes l 
                JOIN users u on u.username=l.user
                JOIN posts p on p.postId=l.post
                WHERE p.owner=? AND l.seen=0 AND user!=?");

        $stmt->bind_param('ss', $username, $_SESSION["username"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $notificationCount += count($result->fetch_all(MYSQLI_ASSOC));

        $stmt = $this->db->prepare("
                SELECT user as sender, profilePic, c.date
                FROM comments c 
                JOIN users u on u.username=c.user
                JOIN posts p on p.postId=c.postId
                WHERE p.owner=? AND c.seen=0 AND user!=?
                ORDER BY c.date DESC");

        $stmt->bind_param('ss', $username, $_SESSION["username"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $notificationCount += count($result->fetch_all(MYSQLI_ASSOC));
        
        return $notificationCount;
    }

    public function getNotifications($username){
        $stmt = $this->db->prepare("
                SELECT f.date, username as sender, profilePic, f.date, ".NotificationTypes::Follow->value." as type
                FROM follows f
                JOIN users u on u.username=f.follower
                WHERE f.followed=? AND f.follower!=?
                ORDER BY f.date DESC");
        $stmt->bind_param('ss', $username, $_SESSION["username"]);
        $stmt->execute();
        $resultFollow = $stmt->get_result();

        $stmt = $this->db->prepare("
                SELECT likeId, p.postId, l.date, user as sender, profilePic, ".NotificationTypes::Like->value." as type
                FROM likes l 
                JOIN users u on u.username=l.user
                JOIN posts p on p.postId=l.post
                WHERE p.owner=? AND user!=?
                ORDER BY l.date DESC");

        $stmt->bind_param('ss', $username, $_SESSION["username"]);
        $stmt->execute();
        $resultLikes = $stmt->get_result();
        
        $stmt = $this->db->prepare("
                SELECT commentId, p.postId, c.date, user as sender, profilePic, c.date, ".NotificationTypes::Comment->value." as type
                FROM comments c 
                JOIN users u on u.username=c.user
                JOIN posts p on p.postId=c.postId
                WHERE p.owner=? AND user!=?
                ORDER BY c.date DESC");

        $stmt->bind_param('ss', $username, $_SESSION["username"]);
        $stmt->execute();
        $resultComments = $stmt->get_result();
        
        return array_merge($resultFollow->fetch_all(MYSQLI_ASSOC),
                            $resultLikes->fetch_all(MYSQLI_ASSOC),
                            $resultComments->fetch_all(MYSQLI_ASSOC));
    }

    public function markNotificationsAsRead($notifications){
        foreach ($notifications as $not) {
            switch($not["type"]) {
                case NotificationTypes::Follow->value:
                    $stmt = $this->db->prepare("
                        UPDATE follows f
                        SET f.seen=1
                        WHERE f.follower=? and f.followed=?
                    ");
                    $stmt->bind_param('ss', $not["sender"], $_SESSION["username"]);
                    $stmt->execute();
                break;
                case NotificationTypes::Like->value:
                    $stmt = $this->db->prepare("
                        UPDATE likes
                        SET seen=1
                        WHERE likeId=?
                    ");
                    $stmt->bind_param('i', $not["likeId"]);
                    $stmt->execute();
                    break;
                case NotificationTypes::Comment->value:
                    $stmt = $this->db->prepare("
                        UPDATE comments
                        SET seen=1
                        WHERE commentId=?
                    ");
                    $stmt->bind_param('i', $not["commentId"]);
                    $stmt->execute();
                    break;
            }
        }
    }

    public function follow($username){
        $stmt = $this->db->prepare("
                INSERT INTO follows
                        (follower, followed, date)
                VALUES  (?, ?, NOW())");
        $stmt->bind_param('ss', $_SESSION["username"], $username);
        $stmt->execute();
    }

    public function unfollow($username){    
        $stmt = $this->db->prepare("
                DELETE FROM follows
                WHERE follower=? AND followed=?");
        $stmt->bind_param('ss', $_SESSION["username"], $username);
        $stmt->execute();
    }

    public function userAlreadyFollowed($username){
        $stmt = $this->db->prepare("
                SELECT IF(EXISTS(
                    SELECT *
                    FROM follows f
                    WHERE f.follower=? and f.followed=?
                 ), 1, 0) as result");
        $stmt->bind_param('ss', $_SESSION["username"], $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC)[0]["result"];
    }
    
    public function getIngredientsMeasures($ingredient) {
        $stmt = $this->db->prepare(
            'SELECT m.*
            FROM expressedin e
            JOIN measures m on m.name = e.unit
            WHERE e.ingredient = ?');
        $stmt->bind_param('s', $ingredient);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createPost($name, $procedure, $ingredients, $tags, $image) {
        $recipe_id = $this->insertRecipe($name, $procedure, $image);
        $this->insertPost($recipe_id);
        $this->insertRecipeIngredients($ingredients, $recipe_id);
        $this->insertRecipeTags($tags, $recipe_id);

    }

    private function insertRecipe($name, $procedure, $image) {
        $image_name = encryptProfilePic($_SESSION['username'], $image['name']);
        $stmt = $this->db->prepare('INSERT INTO `recipes` (`description`, `howTo`, `preview`) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $name, $procedure, $image_name);
        $stmt->execute();

        downloadImage($image, $this, "imgs/posts/" . $image_name);

        return $stmt->insert_id;
    }

    function insertPost($recipe_id) {
        $stmt = $this->db->prepare('INSERT INTO `posts` (`date`, `owner`, `recipe`) VALUES (?, ?, ?)');
        $stmt->bind_param('ssi', date("Y-m-d h:i:sa"), $_SESSION['username'], $recipe_id);
        $stmt->execute();
    }

    function insertRecipeIngredients($ingredients, $recipe_id) {
        $query = "INSERT INTO `compositions` (`recipe`, `ingredient`, `unit`, `quantity`) VALUES ";
        $params = array();
        $params_type = "";

        foreach ($ingredients as $ingredient) {
            [$name, $quantity, $measure] = explode(";", $ingredient);
            $query .= "(?, ?, ?, ?),";
            array_push($params, ...[$recipe_id, $name, $measure, intval($quantity, 10)]);
            $params_type .= 'issi';
        }
        $query = rtrim($query, ',');

        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param($params_type, ...$params);
        $stmt->execute();
    }

    function insertRecipeTags($tags, $recipe_id) {
        $this->insertTags($tags);

        $query = "INSERT INTO `belongto` (`recipe`, `tag`) VALUES ";
        $params = array();
        $params_type = "";

        foreach ($tags as $tag) {
            $query .= "(?, ?),";
            array_push($params, ...[$recipe_id, $tag]);
            $params_type .= 'is';
        }
        $query = rtrim($query, ',');

        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param($params_type, ...$params);
        $stmt->execute();
    }

    public function insertTags($tags) {
        $query = "INSERT IGNORE INTO `tags` (`name`) VALUES ";
        $params = array();
        $params_type = "";

        foreach ($tags as $tag) {
            $query .= "(?),";
            array_push($params, $tag);
            $params_type .= 's';
        }

        $query = rtrim($query, ',');

        $stmt = $this->db->prepare($query);
        $stmt->bind_param($params_type, ...$params);
        $stmt->execute();
    }

    public function getFollowers($username) {
        $stmt = $this->db->prepare("
        SELECT u.profilePic as 'profilePic', f.follower as 'username',
            case when b.followed is null then 
            0
            else
            1
            end as follows_back
        FROM `follows` f
        LEFT JOIN follows b ON b.followed = f.follower AND b.follower = f.followed
        JOIN users u ON u.username = f.follower
        WHERE f.followed = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getFollowings($username) {
        $stmt = $this->db->prepare("SELECT profilePic, followed as username
        FROM `follows` F
        JOIN users ON username = followed
        WHERE follower = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

}
?>