<?php
/**
 * @author Jaap Jansma (CiviCooP) <jaap.jansma@civicoop.org>
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 */

class CRM_Mappingacl_Export_Form_Select extends CRM_Export_Form_Select {

  /**
   * Function to build mapping form element
   *
   */
  function buildMapping() {
    switch ($this->_exportMode) {
      case CRM_Export_Form_Select::CONTACT_EXPORT:
        $exportType = 'Export Contact';
        break;

      case CRM_Export_Form_Select::CONTRIBUTE_EXPORT:
        $exportType = 'Export Contribution';
        break;

      case CRM_Export_Form_Select::MEMBER_EXPORT:
        $exportType = 'Export Membership';
        break;

      case CRM_Export_Form_Select::EVENT_EXPORT:
        $exportType = 'Export Participant';
        break;

      case CRM_Export_Form_Select::PLEDGE_EXPORT:
        $exportType = 'Export Pledge';
        break;

      case CRM_Export_Form_Select::CASE_EXPORT:
        $exportType = 'Export Case';
        break;

      case CRM_Export_Form_Select::GRANT_EXPORT:
        $exportType = 'Export Grant';
        break;

      case CRM_Export_Form_Select::ACTIVITY_EXPORT:
        $exportType = 'Export Activity';
        break;
    }

    $mappingTypeId = CRM_Core_OptionGroup::getValue('mapping_type', $exportType, 'name');
    $this->set('mappingTypeId', $mappingTypeId);

    $mappings = CRM_Core_BAO_Mapping::getMappings($mappingTypeId);

    // Remove the mappings to which a user has no permission to use.
    foreach($mappings as $mapping_id => $mapping) {
      if (!CRM_Mappingacl_Acl::hasAccessToMapping($mapping_id)) {
        unset($mappings[$mapping_id]);
      }
    }

    if (!empty($mappings)) {
      $this->add('select', 'mapping', ts('Use Saved Field Mapping'), array('' => '-select-') + $mappings);
    }
  }

}