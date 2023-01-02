INSERT INTO `recipes` (`recipeId`, `description`, `howTo`, `preview`) VALUES
(0, 'Pizza stravagante', 'Devi fare roba', 'pizza-stravagante.jpg'),
(1, 'Il mio primo dolce-salato', 'Fatelo', 'dolce-salato.jpg'),
(2, 'Oggi cucinaramo por voi', 'Uno dei criteri fondamentali della cucina cinese è l’equilibrio armonioso di colori, sapori e consistenze. Il maiale in agrodolce è una ricetta della tradizione che rappresenta perfettamente questa caratteristica, a partire dalla scelta degli ingredienti: il verde dei peperoni, il rosso del pomodoro e il giallo dell’ananas, un mix dalle tinte vivaci che, insieme alla salsa agrodolce, conferisce al piatto il suo gusto inconfondibile. Dopo aver fritto i bocconcini di carne, mangiare', 'torta-ronaldo.jpg'),
(3, 'Carote', 'Tagliatele', 'carote.jpg');

INSERT INTO `tags` (`name`) VALUES
('breakfast'),
('dinner'),
('first course'),
('lunch'),
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
(0, 'lunch'),
(1, 'breakfast'),
(1, 'vegan'),
(2, 'dinner'),
(3, 'first course');

INSERT INTO `measures` (`name`, `acronym`) VALUES
('unit', 'u'),
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
(2, 'sugar', 'gram', 500),
(2, 'egg', 'unit', 5),
(2, 'flour', 'kilogram', 2),
(2, 'salt', 'spoon', 20),
(2, 'oil', 'litre', 1),
(3, 'carrot', 'unit', 7),
(3, 'oil', 'litre', 1);

INSERT INTO `users` (`username`, `name`, `surname`, `email`, `password`, `profilePic`) VALUES
('carlo61', 'Carlo', 'Conti', 'carlo@conti.com', 'ciao', 'carlo61.jpg'),
('ig_Massari', 'Iginio', 'Massari', 'iginio@massari.com', 'ciao', 'ig_Massari.jpg'),
('cr7', 'Cristiano', 'Ronaldo', 'cris@ronaldo.com', 'ciao', 'cr7.jpg'),
('antonino75', 'Antonino', 'Cannavacciuolo', 'antoninocannavacciuolo@antonino.it', 'ciao', 'antonino75.jfif'),
('aleborghese', 'Alessandro', 'Borghese', 'ale@borghese.it', 'ciao', 'aleborghese.jpg');

INSERT INTO `follows` (`follower`, `followed`, `date`) VALUES
('carlo61', 'ig_Massari', '2022-11-01 00:00:00'),
('carlo61', 'cr7', '2022-11-01 00:00:20');

INSERT INTO `intolerances` (`user`, `ingredient`) VALUES
('carlo61', 'carrot'),
('carlo61', 'pepper');

INSERT INTO `posts` (`postId`, `date`, `owner`, `recipe`) VALUES
(0, '2022-11-18 00:00:00', 'ig_Massari', 1),
(1, '2022-11-09 08:32:15', 'ig_Massari', 0),
(2, '2022-11-24 10:55:21', 'cr7', 2),
(3, '2022-12-30 10:31:43', 'cr7', 3);

INSERT INTO `likes` (`likeId`, `user`, `post`) VALUES
(0, 'carlo61', 0),
(1, 'ig_Massari', 0);

INSERT INTO `comments` (`commentId`, `content`, `date`, `user`, `postId`) VALUES
(0, 'Spacca bro!', '2022-12-20 11:05', 'ig_Massari', 2),
(1, 'Mi fa ribrezzo', '2022-12-21 20:42', 'antonino75', 2),
(2, 'Top', '2022-12-20 10:18', 'carlo61', 2),
(3, 'Sembra veramente deliziosa!! Ottimo lavoro Cristiano!!! Fanne altre ti prego che le voglio portare nei miei ristoranti!', '2022-12-22 15:36', 'aleborghese', 2);

INSERT INTO `expressedin` (`ingredient`, `unit`) VALUES
('carrot', 'unit'),
('carrot', 'gram'),
('flour', 'gram'),
('flour', 'kilogram'),
('egg', 'unit'),
('mint', 'unit'),
('mint', 'gram'),
('oil', 'gram'),
('oil', 'litre'),
('oil', 'spoon'),
('salt', 'gram'),
('salt', 'spoon'),
('sugar', 'gram'),
('sugar', 'spoon'),
('water', 'gram'),
('water', 'litre'),
('rice', 'gram'),
('pepper', 'gram'),
('pepper', 'spoon'),
('rice', 'kilogram');