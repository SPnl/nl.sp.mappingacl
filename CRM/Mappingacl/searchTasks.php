<?php
/**
 * @author Jaap Jansma (CiviCooP) <jaap.jansma@civicoop.org>
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 */

class CRM_Mappingacl_searchTasks {

  public static function searchTasks( $objectName, &$tasks ) {
    foreach ($tasks as $index => $task) {
      if (is_array($task['class']) && $task['class'][0] == 'CRM_Export_Form_Select') {
        $tasks[$index]['class'][0] = 'CRM_Mappingacl_Export_Form_Select';
      }
    }
  }

}