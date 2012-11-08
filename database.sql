-- run me with:
-- \. database.sql

-- WARNING: this will delete anything already stored in the database
DROP DATABASE pictwist;
CREATE DATABASE pictwist;
USE pictwist;

-- create a user with access to this database
GRANT ALL PRIVILEGES ON pictwist.* TO 'pictwist'@'localhost' IDENTIFIED BY 'secret';

CREATE TABLE users(
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(255) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  name VARCHAR(255),
  city VARCHAR(255),
  state VARCHAR(255),
  country VARCHAR(255),
  bio TEXT,
  admin BOOLEAN DEFAULT FALSE,
  updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00',
  created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00'
);
CREATE TRIGGER user_create BEFORE INSERT ON `users`
FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW();
CREATE TRIGGER user_update BEFORE UPDATE ON `users`
FOR EACH ROW SET NEW.updated_at = NOW(), NEW.created_at = OLD.created_at;

-- insert into users(email, password_hash) values ("email", "password");

CREATE TABLE albums(
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255),
  private BOOLEAN DEFAULT FALSE,
  user_id INTEGER,
  FOREIGN KEY (user_id) REFERENCES users(id),
  updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00',
  created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00'
);
CREATE TRIGGER album_create BEFORE INSERT ON `albums`
FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW();
CREATE TRIGGER album_update BEFORE UPDATE ON `albums`
FOR EACH ROW SET NEW.updated_at = NOW(), NEW.created_at = OLD.created_at;

CREATE TABLE photos(
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255) DEFAULT "photo",
  path VARCHAR(255) NOT NULL,
  private BOOLEAN DEFAULT FALSE,
  parent_photo_id INTEGER,
  album_id INTEGER,
  FOREIGN KEY (parent_photo_id) REFERENCES photos(id),
  FOREIGN KEY (album_id) REFERENCES albums(id),
  updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00',
  created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00'
);
CREATE TRIGGER photo_create BEFORE INSERT ON `photos`
FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW();
CREATE TRIGGER photo_update BEFORE UPDATE ON `photos`
FOR EACH ROW SET NEW.updated_at = NOW(), NEW.created_at = OLD.created_at;

CREATE TABLE tags(
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  type VARCHAR(255),
  text VARCHAR(255),
  photo_id INTEGER,
  FOREIGN KEY (photo_id) REFERENCES photos(id),
  updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00',
  created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00'
);
CREATE TRIGGER tag_create BEFORE INSERT ON `tags`
FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW();
CREATE TRIGGER tag_update BEFORE UPDATE ON `tags`
FOR EACH ROW SET NEW.updated_at = NOW(), NEW.created_at = OLD.created_at;

CREATE TABLE comments(
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  text TEXT,
  user_id INTEGER,
  photo_id INTEGER,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (photo_id) REFERENCES photos(id),
  updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00',
  created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00'
);
CREATE TRIGGER comment_create BEFORE INSERT ON `comments`
FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW();
CREATE TRIGGER comment_update BEFORE UPDATE ON `comments`
FOR EACH ROW SET NEW.updated_at = NOW(), NEW.created_at = OLD.created_at;


-- -- TODO: favorites linker table (member favorites many photos), subscriptions between members, shared private albums