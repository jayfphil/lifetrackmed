

-- Create database

CREATE DATABASE lifetrackmed;

-- and use...

USE lifetrackmed;

-- Create table for data

CREATE TABLE user_account(
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  account int(10) NOT NULL,
  stmTimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Stores user data';

CREATE TABLE account(
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  account_id int(10) NOT NULL,
  amount decimal(255) NOT NULL,
  currency varchar(10) NOT NULL,
  comment varchar(220) NOT NULL,
  stmTimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Stores account data';

