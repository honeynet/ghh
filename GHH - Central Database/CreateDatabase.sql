CREATE TABLE `logs` (
  ID int(11) NOT NULL auto_increment,
  Owner varchar(255) NOT NULL default '',
  Tripped varchar(255) NOT NULL default '',
  TimeOfAttack datetime NOT NULL default '0000-00-00 00:00:00',
  Host varchar(255) NOT NULL default '',
  RequestURI varchar(255) NOT NULL default '',
  Referrer varchar(255) NOT NULL default '',
  Accepts varchar(255) NOT NULL default '',
  AcceptsCharset varchar(255) NOT NULL default '',
  AcceptLanguage varchar(255) NOT NULL default '',
  Connection varchar(255) NOT NULL default '',
  keepalive varchar(255) NOT NULL default '',
  UserAgent varchar(255) NOT NULL default '',
  Signatures varchar(255) NOT NULL default '',
  PRIMARY KEY  (ID)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;