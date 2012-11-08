insert into users(email, password_hash, name) values ("email@gmail.com", "HASHED_PASSWORD", "Joe Joerson");
insert into albums(title, user_id) values ("The Beach", (select id from users where name="Joe Joerson"));
insert into photos(title, path, album_id) values ("sweet ocean pic", "/tmp/ocean.png", (select id from albums where title="The Beach"));
insert into photos(title, path, album_id) values ("cool pic of sand", "/tmp/sand.png", (select id from albums where title="The Beach"));