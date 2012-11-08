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
  date_created TIMESTAMP,
  date_modified TIMESTAMP
  -- no security questions - you're not supposed to use them
);

CREATE TABLE albums(
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255),
  private BOOLEAN DEFAULT FALSE,
  date_created TIMESTAMP,
  date_modified TIMESTAMP,
  user_id INTEGER,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE photos(
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255) DEFAULT "photo",
  private BOOLEAN DEFAULT FALSE,
  date_created TIMESTAMP,
  date_modified TIMESTAMP,
  parent_photo_id INTEGER,
  album_id INTEGER,
  FOREIGN KEY (parent_photo_id) REFERENCES photos(id),
  FOREIGN KEY (album_id) REFERENCES albums(id)
);

CREATE TABLE tags(
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  type VARCHAR(255),
  text VARCHAR(255),
  photo_id INTEGER,
  FOREIGN KEY (photo_id) REFERENCES photos(id)
);

CREATE TABLE comments(
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  text TEXT,
  date_created TIMESTAMP,
  user_id INTEGER,
  photo_id INTEGER,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (photo_id) REFERENCES photos(id)
);

-- TODO: favorites linker table (member favorites many photos), subscriptions between members, shared private albums