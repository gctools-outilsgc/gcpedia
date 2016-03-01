--
-- SQL schema update for AJAXPoll extension to add the poll_show_results_before_voting field
--
ALTER TABLE /*_*/ajaxpoll_info ADD poll_show_results_before_voting TINYINT(1);
