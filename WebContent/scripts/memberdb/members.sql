CREATE TABLE members (
 id int(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 username varchar(65) NOT NULL,
 password varchar(65) NOT NULL,
 email varchar(65) NOT NULL UNIQUE
);