#
# Table structure for table 'tx_pinkpoint_domain_model_sector'
#
CREATE TABLE tx_pinkpoint_domain_model_sector (

	name varchar(255) DEFAULT '' NOT NULL,
	location varchar(255) DEFAULT '' NOT NULL,
	country int(11) DEFAULT '0' NOT NULL,
	latitude double(11,2) DEFAULT '0.00' NOT NULL,
	longitude varchar(255) DEFAULT '' NOT NULL,
	image int(11) unsigned NOT NULL default '0',
	sectorcanvas mediumblob DEFAULT '',
	sector_admins int(11) unsigned DEFAULT '0' NOT NULL,
	routes int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (

	gender int(11) DEFAULT '0' NOT NULL,
	avatarimage varchar(255) DEFAULT '' NOT NULL,
	ascents int(11) unsigned DEFAULT '0' NOT NULL,
	rating int(11) unsigned DEFAULT '0',
	sectors int(11) unsigned DEFAULT '0',
	message_box int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_pinkpoint_domain_model_route'
#
CREATE TABLE tx_pinkpoint_domain_model_route (

	sector int(11) unsigned DEFAULT '0' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	grade int(11) DEFAULT '0' NOT NULL,
	length int(11) DEFAULT '0' NOT NULL,
	description text,
	sector_count int(11) DEFAULT '0' NOT NULL,
	ratings int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_pinkpoint_domain_model_ascent'
#
CREATE TABLE tx_pinkpoint_domain_model_ascent (

	climber int(11) unsigned DEFAULT '0' NOT NULL,
	ascent_date int(11) DEFAULT '0' NOT NULL,
	ascent_art int(11) DEFAULT '0' NOT NULL,
	public_visible smallint(5) unsigned DEFAULT '0' NOT NULL,
	comment text,
	route int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_pinkpoint_domain_model_routerating'
#
CREATE TABLE tx_pinkpoint_domain_model_routerating (

	climber int(11) unsigned DEFAULT '0' NOT NULL,
	rating int(11) DEFAULT '0' NOT NULL,
	route int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_pinkpoint_sector_climber_mm'
#
CREATE TABLE tx_pinkpoint_sector_climber_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);
