<?php
/**
 * @author Jaap Jansma (CiviCooP) <jaap.jansma@civicoop.org>
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 */

class CRM_Mappingacl_Acl {

  public static function getExtraPermissions(&$permissions) {
    $permissions['access to use all mappings'] = ts('CiviCRM') . ': ' . ts('Use all export/import mappings');
  }

  /**
   * Checks whether a user has access to use a certain mapping.
   *
   * The access is determined upon two things:
   *  - The user has the permission to use all mappings
   *  - Or the user has permission to use a certain mapping
   *
   * @param $mapping_id
   * @return bool
   */
  public static function hasAccessToMapping($mapping_id) {
    $session = CRM_Core_Session::singleton();
    $contact_id = $session->get('userID');
    if (CRM_Core_Permission::check('access to use all mappings')) {
      $mapping_count = CRM_Core_DAO::singleValueQuery("SELECT COUNT(*) FROM `civicrm_mapping_owner` WHERE `mapping_id` = %1", array (1=>array($mapping_id, 'Integer')));
      if (!$mapping_count) {
        return true;
      }
    }
    $mapping_count = CRM_Core_DAO::singleValueQuery("SELECT COUNT(*) FROM `civicrm_mapping_owner` WHERE `mapping_id` = %1 AND `contact_id` = %2", array (
      1=>array($mapping_id, 'Integer'),
      2=>array($contact_id, 'Integer'),
    ));
    if ($mapping_count) {
      return true;
    }
    return false;
  }

  /**
   * Also save the contact id of the user who created the mapping
   *
   * @param $dao
   */
  public static function postSave($dao) {
    $session = CRM_Core_Session::singleton();
    $contact_id = $session->get('userID');
    $system_wide_mapping = CRM_Core_Permission::check('access to use all mappings');
    if ($system_wide_mapping) {
      CRM_Core_DAO::executeQuery("DELETE FROM `civicrm_mapping_owner` WHERE `mapping_id` = %1", array(1=>array($dao->id, 'Integer')));
    } else {
      CRM_Core_DAO::executeQuery("DELETE FROM `civicrm_mapping_owner` WHERE `mapping_id` = %1 AND `contact_id` = %2", array(
        1=>array($dao->id, 'Integer'),
        2=>array($contact_id, 'Integer')
      ));

      CRM_Core_DAO::executeQuery("INSERT INTO `civicrm_mapping_owner` (`mapping_id`, `contact_id`) VALUES (%1, %2)", array(
        1=>array($dao->id, 'Integer'),
        2=>array($contact_id, 'Integer')
      ));
    }
  }

}