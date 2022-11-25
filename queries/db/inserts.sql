INSERT INTO `recipes` (`recipeId`, `description`, `howTo`, `preview`) VALUES
(0, 'Pizza stravagante', 'Devi fare roba', 'imgs/posts/pizza-stravagante.jpg'),
(1, 'Il mio primo dolce-salato', 'Fatelo', 'imgs/posts/dolce-salato.jpg'),
(2, 'Oggi cucinaramo por voi', 'In forno por dos ore', 'imgs/posts/torta-ronaldo.jpg');

INSERT INTO `tags` (`name`) VALUES
('breakfast'),
('dinner'),
('first course'),
('launch'),
('vegan');

INSERT INTO `ingredients` (`name`, `color`) VALUES
('carrot', 'ff820d'),
('egg', 'faf20a'),
('flour', 'dddddd'),
('mint', '53ed51'),
('oil', '9be317'),
('pepper', '3b3b3b'),
('rice', 'bdb4ac'),
('salt', 'e3e3e3'),
('sugar', 'd1d1d1'),
('water', '03fcbe');

INSERT INTO `belongto` (`recipe`, `tag`) VALUES
(0, 'dinner'),
(0, 'launch'),
(1, 'breakfast'),
(1, 'vegan'),
(2, 'dinner');

INSERT INTO `measures` (`name`, `acronym`) VALUES
('unit', ''),
('gram', 'gr'),
('kilogram', 'kg'),
('litre', 'L'),
('spoon', 'tbsp');

INSERT INTO `compositions` (`recipe`, `ingredient`, `unit`, `quantity`) VALUES
(0, 'egg', 'unit', 3),
(0, 'flour', 'kilogram', 1),
(0, 'oil', 'litre', 2),
(1, 'salt', 'spoon', 4),
(1, 'sugar', 'gram', 25),
(2, 'sugar', 'gram', 500);

INSERT INTO `users` (`username`, `name`, `surname`, `email`, `password`, `profilePic`) VALUES
('carlo61', 'Carlo', 'Conti', 'carlo@conti.com', 'ciao', 'imgs/propics/carlo61.jpg'),
('ig_Massari', 'Iginio', 'Massari', 'iginio@massari.com', 'ciao', 'imgs/propics/ig_Massari.jpg'),
('cr7', 'Cristiano', 'Ronaldo', 'cris@ronaldo.com', 'ciao', 'imgs/propics/cr7.jpg');

INSERT INTO `follows` (`follower`, `followed`, `date`) VALUES
('carlo61', 'ig_Massari', '2022-11-01 00:00:00'),
('carlo61', 'cr7', '2022-11-01 00:00:20');

INSERT INTO `intolerances` (`user`, `ingredient`) VALUES
('carlo61', 'carrot'),
('carlo61', 'pepper');

INSERT INTO `posts` (`postId`, `date`, `owner`, `recipe`) VALUES
(0, '2022-11-18 00:00:00', 'ig_Massari', 1),
(1, '2022-11-09 08:32:15', 'ig_Massari', 0),
(2, '2022-11-24 10:55:21', 'cr7', 2);

INSERT INTO `likes` (`likeId`, `user`, `post`) VALUES
(0, 'carlo61', 0),
(1, 'ig_Massari', 0);
