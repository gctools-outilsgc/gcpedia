--
-- Adds user_id field to the accepted table
--

ALTER TABLE accepted ADD `user_id` int NOT NULL;
UPDATE accepted a SET `user_id` = (select u.user_id from user u where u.user_name = a.Username);
