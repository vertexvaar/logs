CREATE TABLE tx_logs_log (
  request_id varchar(13) DEFAULT '' NOT NULL,
  time_micro float DEFAULT '0' NOT NULL,
  component varchar(255) DEFAULT '' NOT NULL,
  level tinyint(1) unsigned DEFAULT '0' NOT NULL,
  message text,
  data text,

  KEY request (request_id)
);
