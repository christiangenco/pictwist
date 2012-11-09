USE pictwist;
insert into 
	users(email, password_hash, name, city, state, country, bio, admin) 
	values("atevans@smu.edu", "password", "Aaron Evans", "Seagoville", "Texas", "USA", "Hi. My name is Aaron!", 0);
insert into 
	users(email, password_hash, name, city, state, country, bio, admin) 
	values("nsliwa@smu.edu", "password", "Nicole Sliwa", "Keller", "Texas", "USA", "Hi. My name is Nicole!", 0);
insert into 
	users(email, password_hash, name, city, state, country, bio, admin) 
	values("ckubacak@smu.edu", "password", "Carly Kubacak", "Katy", "Texas", "USA", "Hi. My name is Carly!", 0);
insert into 
	users(email, password_hash, name, city, state, country, bio, admin) 
	values("jshook@smu.edu", "password", "Jarret Shook", "Kinnelon", "New Jersey", "USA", "Hi. My name is Jarret!", 0);
insert into 
	users(email, password_hash, name, city, state, country, bio, admin) 
	values("lmarmolejo@smu.edu", "password", "Lauren Marmolejo", "Round Rock", "Texas", "USA", "Hi. My name is Lauren!", 0);

insert into albums(title, private, user_id) values("Favorites", 0, 1);
insert into albums(title, private, user_id) values("Favorites", 0, 2);
insert into albums(title, private, user_id) values("Favorites", 0, 3);
insert into albums(title, private, user_id) values("Favorites", 0, 4);
insert into albums(title, private, user_id) values("Favorites", 0, 5);

insert into albums(title, private, user_id) values("Default", 0, 1);  
insert into albums(title, private, user_id) values("Default", 0, 2);
insert into albums(title, private, user_id) values("Default", 0, 3); 
insert into albums(title, private, user_id) values("Default", 0, 4); 
insert into albums(title, private, user_id) values("Default", 0, 5);