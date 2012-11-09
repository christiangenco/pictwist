-- run me with:
-- \. database.sql

-- WARNING: this will delete anything already stored in the database
DROP DATABASE pictwist;
CREATE DATABASE pictwist;
USE pictwist;

-- create a user with access to this database
GRANT ALL PRIVILEGES ON pictwist.* TO 'pictwist'@'localhost' IDENTIFIED BY 'secret';

# Creating Users table
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

# Creating Albums table
CREATE TABLE albums(
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255),
  private BOOLEAN DEFAULT FALSE,
  user_id INTEGER,
  FOREIGN KEY (user_id) REFERENCES users(id)
    ON UPDATE Cascade
    ON DELETE Cascade,
  updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00',
  created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00'
);
CREATE TRIGGER album_create BEFORE INSERT ON `albums`
FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW();
CREATE TRIGGER album_update BEFORE UPDATE ON `albums`
FOR EACH ROW SET NEW.updated_at = NOW(), NEW.created_at = OLD.created_at;

# Creating Photos table
CREATE TABLE photos(
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255) DEFAULT "photo",
  path VARCHAR(255) NOT NULL,
  private BOOLEAN DEFAULT FALSE,
  views INTEGER DEFAULT 0,
  parent_photo_id INTEGER,
  album_id INTEGER,
  FOREIGN KEY (parent_photo_id) REFERENCES photos(id)
    ON UPDATE Cascade
    ON DELETE Cascade,
  FOREIGN KEY (album_id) REFERENCES albums(id)
    ON UPDATE Cascade
    ON DELETE Cascade,
  updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00',
  created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00'
);
CREATE TRIGGER photo_create BEFORE INSERT ON `photos`
FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW();
CREATE TRIGGER photo_update BEFORE UPDATE ON `photos`
FOR EACH ROW SET NEW.updated_at = NOW(), NEW.created_at = OLD.created_at;

# Creating (Members) Tag (Photos) table
CREATE TABLE tags(
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  type VARCHAR(255),
  text VARCHAR(255),
  photo_id INTEGER,
  FOREIGN KEY (photo_id) REFERENCES photos(id)
    ON UPDATE Cascade
    ON DELETE Cascade,
  updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00',
  created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00'
);
CREATE TRIGGER tag_create BEFORE INSERT ON `tags`
FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW();
CREATE TRIGGER tag_update BEFORE UPDATE ON `tags`
FOR EACH ROW SET NEW.updated_at = NOW(), NEW.created_at = OLD.created_at;

# Creating (Members) CommentOn (Photos) table
CREATE TABLE comments(
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  text TEXT,
  user_id INTEGER,
  photo_id INTEGER,
  FOREIGN KEY (user_id) REFERENCES users(id)
    ON UPDATE Cascade
    ON DELETE Cascade,
  FOREIGN KEY (photo_id) REFERENCES photos(id)
    ON UPDATE Cascade
    ON DELETE Cascade,
  updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00',
  created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00'
);
CREATE TRIGGER comment_create BEFORE INSERT ON `comments`
FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW();
CREATE TRIGGER comment_update BEFORE UPDATE ON `comments`
FOR EACH ROW SET NEW.updated_at = NOW(), NEW.created_at = OLD.created_at;

# Creating (Members) Favorite (Photos) table
CREATE TABLE favorites(
  photo_id INTEGER,           
  user_id INTEGER,          
  PRIMARY KEY (photo_id, user_id),
  FOREIGN KEY (photo_id) REFERENCES photos(id)
    ON UPDATE Cascade
    ON DELETE Cascade,
  FOREIGN KEY (user_id) REFERENCES users(id)
    ON UPDATE Cascade
    ON DELETE Cascade,
  updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00',
  created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00'
);
CREATE TRIGGER favorite_create BEFORE INSERT ON `favorites`
FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW();
CREATE TRIGGER favorite_update BEFORE UPDATE ON `favorites`
FOR EACH ROW SET NEW.updated_at = NOW(), NEW.created_at = OLD.created_at;

# Creating (Users) SubscribeTo (Photos) table
CREATE table subscribes(
  user_id INTEGER,         
  user_id_subscriber INTEGER,          
  PRIMARY KEY (user_id, user_id_subscriber),
  FOREIGN KEY (user_id) REFERENCES users(id)
    ON UPDATE Cascade
    ON DELETE Cascade,
  FOREIGN KEY (user_id_subscriber) REFERENCES users(id)
    ON UPDATE Cascade
    ON DELETE Cascade,
  updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00',
  created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00'
);
CREATE TRIGGER subscribe_create BEFORE INSERT ON `subscribes`
FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW();
CREATE TRIGGER subscribe_update BEFORE UPDATE ON `subscribes`
FOR EACH ROW SET NEW.updated_at = NOW(), NEW.created_at = OLD.created_at;

# Creating (Albums) AreSharedWith (Users) table
CREATE table shared(
  user_id INTEGER,          
  album_id INTEGER,            
  PRIMARY KEY (user_id, album_id),
  FOREIGN KEY (user_id) REFERENCES users(id)
    ON UPDATE Cascade
    ON DELETE Cascade,
  FOREIGN KEY (album_id) REFERENCES albums(id)
    ON UPDATE Cascade
    ON DELETE Cascade,
  updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00',
  created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00'
);
CREATE TRIGGER shared_create BEFORE INSERT ON `shared`
FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW();
CREATE TRIGGER shared_update BEFORE UPDATE ON `shared`
FOR EACH ROW SET NEW.updated_at = NOW(), NEW.created_at = OLD.created_at;
