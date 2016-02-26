<?php
/**
 * @license http://hardsoft321.org/license/ GPLv3
 * @author  Evgeny Pervushin <pea@lab321.ru>
 * @package subpanel_mass_remove
 *
 * Массовое удаление связей
 */

if(empty($this) || empty($this->bean) || empty($this->bean->id)) {
    sugar_die(translate('ERROR_NO_RECORD'));
}
$bean = $this->bean;

if(in_array($bean->module_name, array('Users', 'SecurityGroups', 'ACLRoles'))
    && !is_admin($GLOBALS['current_user']))
{
    sugar_die("Permission denied");
}

if(empty($_POST['linked_id']) || empty($_POST['linked_field'])) {
    sugar_die("linked_field and linked_id required");
}

$linked_field = $_POST['linked_field'];
$linked_id = $_REQUEST['linked_id'];

if(!$bean->load_relationship($linked_field)) {
    sugar_die('Relationship not loaded');
}

$GLOBALS['log']->debug("Mass deleting relationships: bean: {$bean->module_name}, linked_field: $linked_field, linked_id: $linked_id");

if(is_array($linked_id)) {
    foreach($linked_id as $rel_id) {
        $bean->$linked_field->delete($bean->id, $rel_id);
    }
}
else if($linked_id == 'all') {
    $bean->$linked_field->delete($bean->id);
}

echo json_encode(array('saved' => 1, 'errors' => array()));
