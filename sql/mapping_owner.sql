CREATE TABLE `civicrm_mapping_owner` (
  mapping_id int (10) unsigned not null,
  contact_id int (10) unsigned not null,
  primary key (mapping_id, contact_id),
  CONSTRAINT mapping_id_fk_constraint FOREIGN KEY (mapping_id) REFERENCES civicrm_mapping (id) ON DELETE CASCADE,
  CONSTRAINT contact_id_fk_constraint FOREIGN KEY (contact_id) REFERENCES civicrm_contact (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;