DROP DATABASE IF EXISTS onlyfood;
CREATE DATABASE onlyfood;
USE onlyfood;

CREATE TABLE users (
	username varchar(20) NOT NULL,
	name varchar(50) NOT NULL,
	surname varchar(50) NOT NULL,
	email varchar(50) NOT NULL,
	password varchar(255) NOT NULL,
	profilePic varchar(100) NOT NULL,
	CONSTRAINT PK_users PRIMARY KEY (username),
	CONSTRAINT UN_email UNIQUE (email)
);
CREATE TABLE follows (
	follower varchar(20) NOT NULL,
	followed varchar(20) NOT NULL,
	date datetime NOT NULL,
	seen int NOT NULL DEFAULT 0,
	CONSTRAINT PK_follows PRIMARY KEY (follower, followed),
	CONSTRAINT FK_follows_follower FOREIGN KEY (follower) REFERENCES users(username),
	CONSTRAINT FK_follows_followed FOREIGN KEY (followed) REFERENCES users(username)
);
CREATE TABLE recipes (
	recipeId int NOT NULL AUTO_INCREMENT,
	description varchar(50) NOT NULL,
	howTo varchar(5000) NOT NULL,
	preview varchar(100) NOT NULL,
	CONSTRAINT PK_recipes PRIMARY KEY (recipeId)
);
CREATE TABLE posts (
	postId int NOT NULL AUTO_INCREMENT,
	date datetime NOT NULL,
	owner varchar(20) NOT NULL,
	recipe int NOT NULL,
	CONSTRAINT PK_posts PRIMARY KEY (postId),
	CONSTRAINT FK_posts_owner FOREIGN KEY (owner) REFERENCES users(username),
	CONSTRAINT FK_posts_recipe FOREIGN KEY (recipe) REFERENCES recipes(recipeId)
);
CREATE TABLE comments (
	commentId int NOT NULL AUTO_INCREMENT,
	content varchar(255) NOT NULL,
	date datetime NOT NULL,
	user varchar(20) NOT NULL,
	postId int NOT NULL,
	seen int NOT NULL DEFAULT 0,
	CONSTRAINT PK_comments PRIMARY KEY (commentId),
	CONSTRAINT FK_comments_user FOREIGN KEY (user) REFERENCES users(username),
	CONSTRAINT FK_comments_postId FOREIGN KEY (postId) REFERENCES posts(postId)
);
CREATE TABLE likes (
	likeId int NOT NULL AUTO_INCREMENT,
	user varchar(20) NOT NULL,
	post int NOT NULL,
	date datetime NOT NULL,
	seen int NOT NULL DEFAULT 0,
	CONSTRAINT PK_likes PRIMARY KEY (likeId),
	CONSTRAINT FK_likes_user FOREIGN KEY (user) REFERENCES users(username),
	CONSTRAINT FK_likes_post FOREIGN KEY (post) REFERENCES posts(postId)
);
CREATE TABLE tags (
	name varchar(20) NOT NULL,
	CONSTRAINT PK_tags PRIMARY KEY (name)
);
CREATE TABLE ingredients (
	name varchar(20) NOT NULL,
	color char(6) NOT NULL,
	CONSTRAINT PK_ingredients PRIMARY KEY (name)
);
CREATE TABLE measures (
	name varchar(20) NOT NULL,
	acronym varchar(5) NOT NULL,
	CONSTRAINT PK_measures PRIMARY KEY (name),
	CONSTRAINT UN_acronym UNIQUE (acronym)
);
CREATE TABLE compositions (
	recipe int NOT NULL,
	ingredient varchar(20) NOT NULL,
	unit varchar(20) NOT NULL,
	quantity int NOT NULL,
	CONSTRAINT PK_compositions PRIMARY KEY (recipe,ingredient),
	CONSTRAINT FK_compositions_recipe FOREIGN KEY (recipe) REFERENCES recipes(recipeId),
	CONSTRAINT FK_compositions_ingredient FOREIGN KEY (ingredient) REFERENCES ingredients(name),
	CONSTRAINT FK_compositions_unit FOREIGN KEY (unit) REFERENCES measures(name)
);
CREATE TABLE intolerances (
	user varchar(20) NOT NULL,
	ingredient varchar(20) NOT NULL,
	CONSTRAINT PK_intolerances PRIMARY KEY (user,ingredient),
	CONSTRAINT FK_intolerances_user FOREIGN KEY (user) REFERENCES users(username),
	CONSTRAINT FK_intolerances_ingredient FOREIGN KEY (ingredient) REFERENCES ingredients(name)
);
CREATE TABLE expressedin (
	ingredient varchar(20) NOT NULL,
	unit varchar(20) NOT NULL,
	CONSTRAINT PK_expressedin PRIMARY KEY (ingredient,unit),
	CONSTRAINT FK_expressedin_ingredient FOREIGN KEY (ingredient) REFERENCES ingredients(name),
	CONSTRAINT FK_expressedin_unit FOREIGN KEY (unit) REFERENCES measures(name)
);
CREATE TABLE belongto (
	recipe int NOT NULL,
	tag varchar(20) NOT NULL,
	CONSTRAINT PK_belongto PRIMARY KEY (recipe,tag),
	CONSTRAINT FK_belongto_recipe FOREIGN KEY (recipe) REFERENCES recipes(recipeId),
	CONSTRAINT FK_belongto_tag FOREIGN KEY (tag) REFERENCES tags(name)
);
