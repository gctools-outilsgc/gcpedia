--
-- Adds necessary table to the database
--

CREATE TABLE IF NOT EXISTS accepted (
    `Username` varchar(100),
    `date` varchar(10),
    `user_id` int NOT NULL,
    PRIMARY KEY (`user_id`)

) ENGINE=MyISAM