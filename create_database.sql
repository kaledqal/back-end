DROP DATABASE IF EXISTS kinductfse;
CREATE DATABASE kinductfse;

USE kinductfse;

DROP TABLE IF EXISTS location;
DROP TABLE IF EXISTS players;

CREATE TABLE location (
	   id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	   city VARCHAR(80) NOT NULL,
	   province VARCHAR(80) NOT NULL,
	   country VARCHAR(80) NOT NULL,
	   CONSTRAINT `lctpk`
	   			  PRIMARY KEY (id),
	   CONSTRAINT `unqt`
	   			  UNIQUE (city, province)
	);


 CREATE TABLE  players (
 	  pl_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
 	  loc_id INT NOT NULL,
 	  first_name VARCHAR(80) NOT NULL,
 	  last_name VARCHAR(80) NOT NULL,
 	  age INT UNSIGNED NOT NULL,
 	  CONSTRAINT `plypk`
 	  			 PRIMARY KEY (pl_id),
      CONSTRAINT `pfk`
      			 FOREIGN KEY (loc_id) REFERENCES location (id)
 );
