CREATE TABLE IF NOT EXISTS /*_*/ajaxpoll_info (
  `poll_id` varchar(32) NOT NULL PRIMARY KEY default '',
  `poll_txt` text,
  `poll_show_results_before_voting` TINYINT(1),
  `poll_date` datetime default NULL
) /*$wgDBTableOptions*/;