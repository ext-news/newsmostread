#
# Table structure for table 'tx_news_domain_model_news'
#
CREATE TABLE tx_news_domain_model_news (
	tx_newsmostread_count int(11) DEFAULT '0' NOT NULL,
	tx_newsmostread_enabled int(11) DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_newsmostread_log'
#
CREATE TABLE tx_newsmostread_log (
	ip tinytext,
	log_date date DEFAULT NULL,
	news int(11) DEFAULT '0' NOT NULL,
);