#
			# Table structure for table 'tx_pmshopr_products'
			#
			CREATE TABLE tx_pmshopr_products (
	uid int(11) NOT NULL auto_increment,
				pid int(11) DEFAULT '0' NOT NULL,
				tstamp int(11) DEFAULT '0' NOT NULL,
				crdate int(11) DEFAULT '0' NOT NULL,
				cruser_id int(11) DEFAULT '0' NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	titel tinytext,
	beschreibung text,
	bild text,
	preis tinytext,
	anzahl int(11) DEFAULT '0' NOT NULL,
	counter int(11) DEFAULT '0' NOT NULL,
	
					PRIMARY KEY (uid),
					KEY parent (pid)
			);



			#
			# Table structure for table 'tx_pmshopr_bookings'
			#
			CREATE TABLE tx_pmshopr_bookings (
	uid int(11) NOT NULL auto_increment,
				pid int(11) DEFAULT '0' NOT NULL,
				tstamp int(11) DEFAULT '0' NOT NULL,
				crdate int(11) DEFAULT '0' NOT NULL,
				cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	user_uid text,
	product text,
	
					PRIMARY KEY (uid),
					KEY parent (pid)
			);