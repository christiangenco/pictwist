USE pictwist;
insert into 
	users(email, password_hash, name, city, state, country, bio, admin) 
	values("cgenco@smu.edu", "genco", "Christian Genco", "New York", "New York", "USA", "Hi. My name is Christian!", 0);
insert into 
	users(email, password_hash, name, city, state, country, bio, admin) 
	values("nsliwa@smu.edu", "sliwa", "Nicole Sliwa", "Keller", "Texas", "USA", "Hi. My name is Nicole!", 0);
insert into 
	users(email, password_hash, name, city, state, country, bio, admin) 
	values("crrichards@smu.edu", "richards", "Chase Richards", "Dallas", "Texas", "USA", "Hi. My name is Chase!", 0);
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

insert into albums(title, private, user_id) values("BW Photos", 0, 2);

insert into photos(title, path, album_id) values("Rain on the Water", "uploaded_files/1353821883-picture-rain.jpg", 1);
insert into photos(title, path, album_id) values("Desert Sands", "uploaded_files/1353798070-E488Ph.jpg", 2);
insert into photos(title, path, album_id) values("Bridge at Winter", "uploaded_files/1353797801-il_fullxfull.96948996.jpg", 3);
insert into photos(title, description, path, album_id) values("Pier", "Pier off the Beach", "uploaded_files/1353834707-5620762964_57c9c92615.jpg", 13);
insert into photos(title, description, path, album_id) values("Mountains and the Lake", "Ansel Adams Photograph", "uploaded_files/1353821994-ansel_13.jpg", 13);

insert into tags(type, text, photo_id) values("location", "beach", 4);
insert into tags(type, text, photo_id) values("color", "bw", 4);
insert into tags(type, text, photo_id) values("keyword", "clouds", 4);
insert into tags(type, text, photo_id) values("keyword", "water", 4);
insert into tags(type, text, photo_id) values("keyword", "sand", 4);
insert into tags(type, text, photo_id) values("location", "mountains", 5);
insert into tags(type, text, photo_id) values("keyword", "clouds", 5);
insert into tags(type, text, photo_id) values("color", "bw", 5);
insert into tags(type, text, photo_id) values("keyword", "reflection", 5);
insert into tags(type, text, photo_id) values("keyword", "trees", 5);

insert into comments(text, user_id, photo_id) values("This is so cool!", 2, 4);
insert into comments(text, user_id, photo_id) values("So much white!", 1, 3);
insert into comments(text, user_id, photo_id) values("Creepy...", 3, 4);
insert into comments(text, user_id, photo_id) values("My favorite!", 4, 2);
insert into comments(text, user_id, photo_id) values("Rain drops are falling on my head...", 5, 1);
insert into comments(text, user_id, photo_id) values("Ansel adams!", 6, 5);






