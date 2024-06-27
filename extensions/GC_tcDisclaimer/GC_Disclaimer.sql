--
-- Adds necessary table to the database
--

CREATE TABLE IF NOT EXISTS tc_accepted (
    `user_id` int NOT NULL,
    `username` varchar(100),
    `date` varchar(10),
    PRIMARY KEY (`user_id`)
)