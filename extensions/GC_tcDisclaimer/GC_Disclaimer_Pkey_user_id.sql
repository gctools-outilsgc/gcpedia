--
-- Sets user_id field as the primary key
--

DELETE FROM a USING accepted a WHERE a.user_id IN (SELECT user_id FROM (SELECT user_id FROM accepted) c GROUP BY c.user_id HAVING count(*) > 1);
ALTER TABLE accepted ADD CONSTRAINT PRIMARY KEY (`user_id`);