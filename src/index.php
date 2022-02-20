<?php

function adminer_object()
{
    // required to run any plugin
    include_once "./plugins/plugin.php";

    // autoloader
    foreach (glob("plugins/*.php") as $filename) {
        include_once "./$filename";
    }

    $plugins = [
        new AdminerDatabaseHide([
            'mysql',
            'information_schema',
            'performance_schema',
            'sys'
        ]),
        new AdminerDisplayForeignKeyName(),
        new AdminerTinymce(),
        new AdminerTablesFilter(),
        new AdminerSuggestTableField(),
        new AdminerTheme(),
    ];

    return new AdminerPlugin($plugins);
}

// include original Adminer
include "./adminer.php";

?>
