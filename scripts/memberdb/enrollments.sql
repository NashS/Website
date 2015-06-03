CREATE TABLE enrollments (
 id int(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 uid int(5) NOT NULL,
 eid int(5) NOT NULL,
 FOREIGN KEY (uid) REFERENCES members(id),
 FOREIGN KEY (eid) REFERENCES roles(id),
 CONSTRAINT UNIQUE (uid,eid)
);