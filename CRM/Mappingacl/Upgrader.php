<?php

/**
 * Collection of upgrade steps.
 */
class CRM_Mappingacl_Upgrader extends CRM_Mappingacl_Upgrader_Base {


  public function install() {
    $this->executeSqlFile('sql/mapping_owner.sql');
  }

  public function uninstall() {
   CRM_Core_DAO::executeQuery("DROP TABLE `civicrm_mapping_owner`");
  }

}
