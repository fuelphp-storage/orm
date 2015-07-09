
-- Basic sample posts table
DROP TABLE IF EXISTS posts;

CREATE TABLE posts (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	title VARCHAR( 50 ) NOT NULL ,
	description TEXT NOT NULL ,
	created_at INT NOT NULL DEFAULT '0' ,
	updated_at INT NOT NULL DEFAULT '0' ,
  author_id INT NULL DEFAULT NULL
);

-- Posts have many comments
DROP TABLE IF EXISTS comments;

CREATE TABLE comments (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  post_id INT NOT NULL ,
  body TEXT NOT NULL
);

-- Posts have one author
DROP TABLE IF EXISTS authors;

CREATE TABLE authors (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  name VARCHAR( 15 ) NOT NULL
);

-- Posts have many categories and categories have many posts
DROP TABLE IF EXISTS categories;

CREATE TABLE categories (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  name VARCHAR( 15 ) NOT NULL
);

DROP TABLE IF EXISTS post_categories;

CREATE TABLE post_categories (
  post_id INT NOT NULL ,
  category_id INT NOT NULL
);
