CREATE TABLE IF NOT EXISTS /*_*/mscal_names (
	ID int UNSIGNED NOT NULL auto_increment,
	Cal_Name varchar(255) NOT NULL,
	PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS /*_*/mscal_list (
	ID int UNSIGNED NOT NULL auto_increment,
	Date DATE NOT NULL,
	Text_ID int UNSIGNED NOT NULL,
	Day_of_Set int UNSIGNED NOT NULL DEFAULT 1,
	Cal_ID int UNSIGNED NOT NULL,
	PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS /*_*/mscal_content (
	ID int UNSIGNED NOT NULL auto_increment,
	Text varchar(255) NOT NULL,
	Start_Date DATE NOT NULL,
	Duration int UNSIGNED NOT NULL,
	Yearly int UNSIGNED NOT NULL,
	PRIMARY KEY (ID)
);