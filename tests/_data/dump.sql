
-- Basic sample posts table
DROP TABLE IF EXISTS posts;

CREATE TABLE posts (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	title VARCHAR( 50 ) NOT NULL ,
	description TEXT NOT NULL ,
	created_at INT NOT NULL DEFAULT '0',
	updated_at INT NOT NULL DEFAULT '0'
);
