CREATE TABLE tx_logs_log (
	uid INT(11) NOT NULL AUTO_INCREMENT,
	request_id VARCHAR(13) DEFAULT '' NOT NULL,
	time_micro DOUBLE(16,4) NOT NULL DEFAULT '0.0000',
	component VARCHAR(255) DEFAULT '' NOT NULL,
	level TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
	message TEXT,
	data TEXT,

	PRIMARY KEY (uid),
	KEY request (request_id)
);
