<?php
/**
 * @license http://hardsoft321.org/license/ GPLv3
 * @author  Evgeny Pervushin <pea@lab321.ru>
 * @package subpanel_mass_remove
 */
class SubPanelMassRemove
{
    public function fillIdCheckboxField($bean, $event, $arguments)
    {
        $bean->id_checkbox = '<input type="checkbox" class="choose-in-subpanel" value="'.$bean->id.'" />';
        $bean->field_defs['id_checkbox'] = array(
            'name' => 'id_checkbox',
            'type' => 'varchar',
            'source' => 'non-db',
        );
    }
}
