CREATE TABLE tx_logs_log (
  uid int(11) unsigned NOT NULL auto_increment,
  pid int(11) unsigned DEFAULT '0' NOT NULL,

  request_id varchar(13) DEFAULT '' NOT NULL,
  time_micro decimal(15,4) NOT NULL default '0.0000',
  component varchar(255) DEFAULT '' NOT NULL,
  level tinyint(1) unsigned DEFAULT '0' NOT NULL,
  message text,
  data text,

  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY request (request_id)
) ENGINE=InnoDB;
