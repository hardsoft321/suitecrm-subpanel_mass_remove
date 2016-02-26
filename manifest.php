<?php
$manifest = array(
    'name' => 'subpanel_mass_remove',
    'acceptable_sugar_versions' => array(),
    'acceptable_sugar_flavors' => array('CE'),
    'author' => 'hardsoft321',
    'description' => 'Массовое удаление связей через субпанель',
    'is_uninstallable' => true,
    'published_date' => '2016-02-25',
    'type' => 'module',
    'version' => '1.0.0',
);
$installdefs = array(
    'id' => 'subpanel_mass_remove',
    'action_file_map' => array(
        array(
            'from' => '<basepath>/source/action_file_map/MassDeleteRelationships.php',
            'to_module' => 'application',
        ),
    ),
    'copy' => array(
        array(
            'from' => '<basepath>/source/copy',
            'to' => '.'
        ),
    ),
    'language' => array(
        array (
            'from' => '<basepath>/source/language/application/ru_ru.lang.php',
            'to_module' => 'application',
            'language' => 'ru_ru',
        ),
        array (
            'from' => '<basepath>/source/language/application/en_us.lang.php',
            'to_module' => 'application',
            'language' => 'en_us',
        ),
    ),
    'logic_hooks' => array(
        array(
            'module' => '',
            'hook' => 'process_record',
            'order' => 150,
            'description' => 'Fill id checkbox',
            'file' => 'custom/include/SubPanelMassRemove.php',
            'class' => 'SubPanelMassRemove',
            'function' => 'fillIdCheckboxField',
        ),
    ),
);
