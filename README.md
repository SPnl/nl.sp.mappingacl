# Mapping ACL

The extension adds a drupal permission _Use all export/import mappings_.
Based on that permission the user can use all export/import mappings or the user can only use his/her own mappings.

## Technical implementation

The extension adds a drupal permission _Use all export/import mappings_.
The hook _hook_civicrm_searchTasks_ is used to replace the export search task with our modification of the
form _CRM_Export_Form_Select_. In that form we tweak the way mappings are retrieved.

When a mapping is saved in the database and the user does not have the permission _Use all export/import mappings_ we
will also store the user ID with the mapping. We will use that user ID to determine whether this is a system wide mapping.
When no user ID is stored then the mapping is a system wide mapping and to use that mapping a user needs the permission
_Use all export/import mappings_.