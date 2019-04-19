CREATE DATABASE if not exists test_db;


USE test_db;

CREATE TABLE admin (
	id int(11) AUTO_INCREMENT NOT NULL,
	username varchar(30) NOT NULL,
	passcode varchar(30) NOT NULL,
	email varchar(50) NOT NULL,
	forgotpass varchar(50)
	forgotexp varchar(15)
	PRIMARY KEY (id),
	UNIQUE KEY username (username)
);

/*CREATE USERS*/
USE test_db;
INSERT INTO admin (username, passcode, email)
VALUES("johndoe", "abc1234", "john@john.com");

INSERT INTO admin (username, passcode, email)
VALUES("janedoe", "abc1234", "jane@jane.com");

-- DELETE A COLUMN
ALTER TABLE admin
DROP email2, DROP text2;

-- DELETE A FIELD
UPDATE admin SET forgotpass = NULL WHERE something = something

-- ADD A COLUMN AFTER/BEFORE ANOTHER
ALTER TABLE admin
ADD passcode varchar(50)
AFTER username;

-- CHANGE DATA
UPDATE admin
SET	passcode = "4321cba"
WHERE username = "janedoe";

-- DELETE USER
DELETE FROM admin
WHERE username = "janedoe";

-- CHANGE COLUMN SETTINGS
ALTER TABLE users MODIFY COLUMN passcode VARCHAR(50);

-- DELETE TABLE
DROP TABLE test_db.admin;

-- DELETE ALL DATA WITHIN A TABLE
TRUNCATE TABLE test_db.users;
