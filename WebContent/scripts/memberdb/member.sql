CREATE DATABASE member;

CREATE USER memberroot@localhost;

SET PASSWORD FOR memberroot@localhost = PASSWORD('1234');

GRANT ALL PRIVILEGES ON member.* TO 'memberroot'@'localhost';