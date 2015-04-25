CREATE DATABASE blog;

CREATE USER wpusr@localhost;

SET PASSWORD FOR wpusr@localhost = PASSWORD('1234');

GRANT ALL PRIVILEGES ON blog.* TO 'wpusr'@'localhost';

FLUSH PRIVILEGES;