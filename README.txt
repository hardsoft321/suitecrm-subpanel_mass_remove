# Массовое удаление связей через субпанель

Отдельно для нужных модулей вписать в layoutdefs строки для добавления кнопок, например, для пользователей так

```php
if(is_admin($GLOBALS['current_user'])) {
    $layout_defs['Users']['subpanel_setup']['securitygroups']['top_buttons'][] = array('widget_class' => 'SubPanelTopButtonMassRemove', 'scope' => 'selected');
    $layout_defs['Users']['subpanel_setup']['securitygroups']['top_buttons'][] = array('widget_class' => 'SubPanelTopButtonMassRemove', 'scope' => 'all');
}
```

```php
В субпанель $subpanel_layout['list_fields'] добавить столбец с чекбоксами
    'id_checkbox' => array(
        'vname' => 'LBL_ID_CHECKBOX_TITLE',
        'width' => '1%',
        'sortable' => false,
    )
```
