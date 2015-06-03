INSERT INTO roles 
	(role)
VALUES ('teacher');
INSERT INTO roles 
	(role)
VALUES ('Moonbeams');
INSERT INTO roles 
	(role)
VALUES ('Sunshine');
INSERT INTO roles 
	(role)
VALUES ('Sunbeams');

UPDATE roles SET ROLE = "Moonbeams" WHERE id = 2;
UPDATE roles SET ROLE = "Sunshine" WHERE id = 3;
UPDATE roles SET ROLE = "Sunbeams" WHERE id = 4;