-- PostgreSQL table structure for table favoritelist

CREATE TABLE IF NOT EXISTS favoritelist (
  fl_user INTEGER unsigned NOT NULL,
  fl_namespace INTEGER NOT NULL default 0,
  fl_title TEXT NOT NULL default '',
  -- FIXME: Nothing populates this, this is always null?!
  fl_notificationtimestamp TIMESTAMPTZ default NULL
);

CREATE UNIQUE INDEX fl_user ON favoritelist (fl_user, fl_namespace, fl_title);
CREATE INDEX fl_namespace_title ON favoritelist (fl_namespace, fl_title);
