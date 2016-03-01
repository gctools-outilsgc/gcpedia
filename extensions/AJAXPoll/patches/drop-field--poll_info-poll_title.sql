--
-- SQL schema update for AJAXPoll extension to drop poll_info.poll_title field since version 1.72
--

ALTER TABLE /*_*/poll_info DROP poll_title;
