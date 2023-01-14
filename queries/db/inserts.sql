INSERT INTO `recipes` (`recipeId`, `description`, `howTo`, `preview`) VALUES
(0, 'Pizza stravagante', 'Devi fare roba', 'pizza-stravagante.jpg'),
(1, 'Il mio primo dolce-salato', 'Fatelo', 'dolce-salato.jpg'),
(2, 'Oggi cucinaramo por voi', 'Uno dei criteri fondamentali della cucina cinese è l’equilibrio armonioso di colori, sapori e consistenze. Il maiale in agrodolce è una ricetta della tradizione che rappresenta perfettamente questa caratteristica, a partire dalla scelta degli ingredienti: il verde dei peperoni, il rosso del pomodoro e il giallo dell’ananas, un mix dalle tinte vivaci che, insieme alla salsa agrodolce, conferisce al piatto il suo gusto inconfondibile. Dopo aver fritto i bocconcini di carne, mangiare', 'torta-ronaldo.jpg'),
(3, 'Carote', 'Tagliatele', 'carote.jpg'),
(4, "Spaghetti Bolognese", "1. Heat olive oil in a large pan over medium heat. Add diced onions and minced garlic, and cook for a few minutes until softened. 2. Add ground beef and cook until browned. 3. Stir in canned tomatoes, tomato paste, and Italian seasoning. 4. Bring to a simmer and let cook for 20 minutes. 5. Cook spaghetti according to package instructions. 6. Serve beef sauce over cooked spaghetti, and top with grated Parmesan cheese.", "spaghetti with meat sauce"),
(5, "Lemon and Herb Roasted Chicken", "1. Preheat the oven to 220°C. 2. In a small bowl, mix together lemon zest, garlic, herbs, and olive oil. 3. Season chicken with salt and pepper, then rub the lemon and herb mixture all over the chicken. 4. Place chicken in a roasting pan and roast for 40-45 minutes, or until the internal temperature reaches 74°C. 5. Let the chicken rest for 10 minutes before slicing and serving."),
(6, "Chocolate Chip Cookies", "1. In a large mixing bowl, cream together the butter and sugar until light and fluffy. 2. Beat in the egg and vanilla extract. 3. In a separate bowl, whisk together the flour, baking soda, and salt. 4. Gradually add the dry ingredients to the butter mixture, mixing until just combined. 5. Stir in the chocolate chips. 6. Roll the dough into balls and place them on a baking sheet. 7. Bake at 180°C for 10-12 minutes, or until the edges are golden brown.", "chocolate chip cookies");

INSERT INTO `tags` (`name`) VALUES
("foodporn"),
("yum"),
("foodstagram"),
("instafood"),
("delicious"),
("tasty"),
("nom"),
("foodie"),
("hungry"),
("dinner"),
("lunch"),
("breakfast"),
("dessert"),
("vegan"),
("vegetarian"),
("glutenfree"),
("healthy"),
("homemade"),
("cooking"),
("baking"),
("grilling"),
("bbq"),
("restaurant"),
("fastfood"),
("streetfood"),
("seafood"),
("sushi"),
("pizza"),
("pasta"),
("chinese"),
("indian"),
("mexican"),
("italian"),
("french");

INSERT INTO `ingredients` (`name`, `color`)
VALUES 
("tomatoes", "ff0000"),
("carrots", "ffa500"),
("spinach", "00ff00"),
("blueberries", "0000ff"),
("strawberries", "ff00ff"),
("raspberries", "ff7700"),
("blackberries", "000000"),
("bananas", "ffff00"),
("avocados", "66ff99"),
("lemons", "ffff00"),
("limes", "00ff00"),
("cucumbers", "009933"),
("pumpkin", "ff9900"),
("ginger", "ff3300"),
("onions", "ff6600"),
("garlic", "999999"),
("chicken breast", "ffcc99"),
("ground beef", "ff0000"),
("salmon fillet", "ff6699"),
("shrimps", "ffcc99"),
("tofu", "cccccc"),
("lentils", "cc9966"),
("black beans", "333333"),
("kidney beans", "990000"),
("chickpeas", "663300"),
("quinoa", "99cc00"),
("brown rice", "663300"),
("peas", "009933"),
("corn", "ffcc00"),
("broccoli", "006600"),
("cauliflower", "ffffcc"),
("brussels sprouts", "996633"),
("potatoes", "ffcc99"),
("sweet potatoes", "ff6600"),
("yams", "ff3300"),
("apples", "ff0000"),
("oranges", "ffa500"),
("pears", "ffff00"),
("mangoes", "ffcc00"),
("pineapple", "ffff00"),
("cantaloupe", "ffcc66"),
("watermelon", "669900"),
("kiwi", "99cc00"),
("grapes", "663300"),
("plums", "990000"),
("figs", "663300"),
("dates", "cc9966");


INSERT INTO `belongto` (`recipe`, `tag`) VALUES
(0, 'dinner'),
(0, 'lunch'),
(1, 'breakfast'),
(1, 'vegan'),
(2, 'dinner'),
(3, 'first course');

INSERT INTO `measures` (`name`, `acronym`) VALUES
("teaspoon", "tsp"),
("tablespoon", "tbsp"),
("cup", "c"),
("pint", "pt"),
("quart", "qt"),
("gallon", "gal"),
("milliliter", "mL"),
("liter", "L"),
("milligram", "mg"),
("gram", "g"),
("kilogram", "kg"),
("ounce", "oz"),
("pound", "lb"),
("count", "cnt"),
("piece", "pc"),
("slice", "slc");


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