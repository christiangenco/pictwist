##########################
# Photo Mangager: PicTwist
# DB Creation
##########################

##########################
# Clearing / Creating DB
##########################

DROP database IF EXISTS PicTwist;       		# "drops" database (deletes) if the DB already exists 

CREATE database PicTwist;               		# creates the DB

USE PicTwist;                           		# tells which DB to use

##########################
# Creating Tables
##########################

# Creating Members table
CREATE table members(                
memID int AUTO_INCREMENT,			  			# auto generated member ID - 11 is max length
isAdmin boolean default 0,						# admin status, set to true if admin, false by default
fname varchar(15) NOT NULL,         			# first name -- required 
lname varchar(15) NOT NULL,                  	# last name  -- required 
email varchar(20) NOT NULL UNIQUE,  			# email (aka username) -- required
pwd varchar(64) NOT NULL,      					# password --required, encrypted using SHA256
city varchar(20),			          			# city -- required 
state varchar(20),			     				# state or province -- required
country varchar(20) NOT NULL,        			# country -- required
bio varchar(200),								# user biography -- optional
join_d date NOT NULL,							# joined date -- required
active_d date NOT NULL,							# last active date -- required
securID int NOT NULL,							# id of security question -- required
securAnswr varchar(20),							# answer to secrity question -- required
PRIMARY KEY (memID)
);

# Creating Albums table
CREATE table albums(
albumID int AUTO_INCREMENT,						# auto generated album ID - 11 is max length
memID int NOT NULL,								# member id of album owner/creater, foreign key -- required
title varchar(20) default "new album",			# title of album, "new album" by default
isPrivate boolean default 0,					# private album status, false (public) by default
add_d date NOT NULL,							# album added date -- required
mod_d date NOT NULL,							# album last modified date -- required
PRIMARY KEY (albumID),
FOREIGN KEY (memID) references members(memID)
	ON UPDATE Cascade
	ON DELETE Cascade
);

# Creating Photos table
CREATE table photos(
photoID int AUTO_INCREMENT,						# auto generated photo ID - 11 is max length
photoID_P int,									# photo id of parent photo -- optional
albumID int NOT NULL,							# id of containing album -- required
title varchar(20) default "new photo",			# title of photo, "new photo" by default
isPrivate boolean default 0,					# private photo status, false (public) by default
add_d date NOT NULL,							# photo added date -- required
location varchar(100) NOT NULL,					# physical address of photo -- required
views int default 0,							# views photo has received, 0 by default
PRIMARY KEY (photoID),
FOREIGN KEY (albumID) references albums(albumID)
	ON UPDATE Cascade
	ON DELETE Cascade,
FOREIGN KEY (photoID_P) references photos(photoID)
	ON UPDATE Cascade
	ON DELETE Cascade
);

# Creating (Members) CommentOn (Photos) table
CREATE table commentOn(
commentID int AUTO_INCREMENT,					# auto generated comment ID - 11 is max length
photoID int NOT NULL,							# id of commented on photo -- required
memID int NOT NULL,								# id of member commenting on photo -- required
add_d date NOT NULL,							# comment added date -- required
contents varchar(200) NOT NULL,					# contents of comment -- required
PRIMARY KEY (commentID),
FOREIGN KEY (photoID) references photos(photoID)
	ON UPDATE Cascade
	ON DELETE Cascade,
FOREIGN KEY (memID) references members(memID)
	ON UPDATE Cascade
	ON DELETE Cascade
);

# Creating (Members) Favorite (Photos) table
CREATE table favorite(
photoID int NOT NULL,							# id of favorited photo -- required
memID int NOT NULL,								# id of member favoriting photo -- required
PRIMARY KEY (photoID, memID),
FOREIGN KEY (photoID) references photos(photoID)
	ON UPDATE Cascade
	ON DELETE Cascade,
FOREIGN KEY (memID) references members(memID)
	ON UPDATE Cascade
	ON DELETE Cascade
);

# Creating (Members) Tag (Photos) table
CREATE table tag(
tagID int AUTO_INCREMENT,						# auto generated tag ID - 11 is max length
memID int NOT NULL,								# id of member adding the tag
photoID int NOT NULL,							# id of photo tagged
type int NOT NULL,								# int referencing type of tag (i.e. location, camera type, person, etc)
contents varchar(20) NOT NULL,					# contents of tag
PRIMARY KEY (tagID),
FOREIGN KEY (memID) references members(memID)
	ON UPDATE Cascade
	ON DELETE Cascade,
FOREIGN KEY (photoID) references photos(photoID)
	ON UPDATE Cascade
	ON DELETE Cascade
);

# Creating (Members) SubscribeTo (Photos) table
CREATE table subscribeTo(
memID int NOT NULL,								# id of member subscribed
memID_A int NOT NULL,							# id of member subscribing (performing Action)
PRIMARY KEY (memID, memID_A),
FOREIGN KEY (memID) references members(memID)
	ON UPDATE Cascade
	ON DELETE Cascade,
FOREIGN KEY (memID_A) references members(memID)
	ON UPDATE Cascade
	ON DELETE Cascade
);

# Creating (Albums) AreSharedWith (Members) table
CREATE table areSharedWith(
memID int NOT NULL,								# id of member getting access to album
albumID int NOT NULL,							# id of album shared
PRIMARY KEY (albumID, memID),
FOREIGN KEY (memID) references members(memID)
	ON UPDATE Cascade
	ON DELETE Cascade,
FOREIGN KEY (albumID) references albums(albumID)
	ON UPDATE Cascade
	ON DELETE Cascade
);