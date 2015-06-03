CREATE TABLE resources (
 id int(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 eid int(5) NOT NULL,
 path varchar(255) NOT NULL,
 resource varchar(255) NOT NULL,
 FOREIGN KEY (eid) REFERENCES roles(id)
);