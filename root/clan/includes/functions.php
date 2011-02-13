<?php
/**
*
*===================================================================
*
*  phpBB Clans -- Main Functions File
*-------------------------------------------------------------------
*    Script info:
* Version:          1.0.0
* Copyright:        (C) 2010 | Bill Swinscoe (Zulcun)
* License:          http://opensource.org/licenses/gpl-2.0.php | GNU Public License v2
* Package:          phpBB3
*
*===================================================================
*
*/

if (!defined('IN_PHPBB'))
{
   exit;
}

// Get clan config
function obtain_clan_config()
{
    global $db;

    $sql = 'SELECT config_name, config_value
        FROM ' . CLAN_CONFIG_TABLE;
    $result = $db->sql_query($sql);

    while ($row = $db->sql_fetchrow($result))
    {
        $cached_clan_config[$row['config_name']] = $row['config_value'];
        $clan_config[$row['config_name']] = $row['config_value'];
    }
    $db->sql_freeresult($result);

    return $clan_config;
}

/**
* Set config value. Creates missing config entry.
*/
function set_clan_config($config_name, $config_value)
{
    global $db, $cache, $clan_config;

    $sql = 'UPDATE ' . CLAN_CONFIG_TABLE . "
        SET config_value = '" . $db->sql_escape($config_value) . "'
        WHERE config_name = '" . $db->sql_escape($config_name) . "'";
    $db->sql_query($sql);

    if (!$db->sql_affectedrows() && !isset($clan_config[$config_name]))
    {
        $sql = 'INSERT INTO ' . CLAN_CONFIG_TABLE . ' ' . $db->sql_build_array('INSERT', array(
            'config_name'    => $config_name,
            'config_value'    => $config_value));
        $db->sql_query($sql);
    }

    $clan_config[$config_name] = $config_value;
}
 
?>
