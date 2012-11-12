USE pictwist;
insert into 
	users(email, password_hash, name, city, state, country, bio, admin) 
	values("cgenco@smu.edu", "genco", "Christian Genco", "New York", "New York", "USA", "Hi. My name is Christian!", 0);
insert into 
	users(email, password_hash, name, city, state, country, bio, admin) 
	values("nsliwa@smu.edu", "sliwa", "Nicole Sliwa", "Keller", "Texas", "USA", "Hi. My name is Nicole!", 0);
insert into 
	users(email, password_hash, name, city, state, country, bio, admin) 
	values("crrichards@smu.edu", "richards", "Carly Kubacak", "Dallas", "Texas", "USA", "Hi. My name is Chase!", 0);
insert into 
	users(email, password_hash, name, city, state, country, bio, admin) 
	values("tcastillo@smu.edu", "castillo", "Tarci Castillo", "Dallas", "Texas", "USA", "Hi. My name is Tarci!", 0);
insert into 
	users(email, password_hash, name, city, state, country, bio, admin) 
	values("mcrews@smu.edu", "crews", "Maryssa Crews", "Dallas", "Texas", "USA", "Hi. My name is Maryssa!", 0);
insert into 
	users(email, password_hash, name, city, state, country, bio, admin) 
	values("jetter@smu.edu", "etter", "Jason Etter", "Dallas", "Texas", "USA", "Hi. My name is Jason!", 0);

insert into albums(title, private, user_id) values("Default", 0, 1);  
insert into albums(title, private, user_id) values("Default", 0, 2);
insert into albums(title, private, user_id) values("Default", 0, 3); 
insert into albums(title, private, user_id) values("Default", 0, 4); 
insert into albums(title, private, user_id) values("Default", 0, 5);
insert into albums(title, private, user_id) values("Default", 0, 6);

insert into albums(title, private, user_id) values("Favorites", 0, 1);
insert into albums(title, private, user_id) values("Favorites", 0, 2);
insert into albums(title, private, user_id) values("Favorites", 0, 3);
insert into albums(title, private, user_id) values("Favorites", 0, 4);
insert into albums(title, private, user_id) values("Favorites", 0, 5);
insert into albums(title, private, user_id) values("Favorites", 0, 6);

insert into photos(title, path, album_id) values("butterfly", "uploaded_files/1352446553-4489468-pair-of-fluffy-fairy-wings-isolated-on-black.jpg", 1);
insert into photos(title, path, album_id) values("vampire", "uploaded_files/1352428817-6_vampire.jpg", 2);
insert into photos(title, path, album_id) values("fairy", "uploaded_files/1352428495-200.jpg", 3);