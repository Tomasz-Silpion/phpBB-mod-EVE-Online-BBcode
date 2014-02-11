<?php
/**
*
* @author Cyerus
* @package eveapi
* @copyright (c) 2012 Cyerus
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
define('UMIL_AUTO', true);
define('IN_PHPBB', true);
define('IN_INSTALL', true);  // Make it able to load from /root/install/ directory.
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

include($phpbb_root_path . 'common.' . $phpEx);

$user->session_begin();
$auth->acl($user->data);
$user->setup('mods/umil_eveonline_bbcode');

if (!file_exists($phpbb_root_path . 'umil/umil_auto.' . $phpEx))
{
	trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
}

require_once($phpbb_root_path . 'install/function_eveonline_bbcode_items.' . $phpEx);
require_once($phpbb_root_path . 'install/function_eveonline_bbcode_ships.' . $phpEx);
require_once($phpbb_root_path . 'install/function_eveonline_bbcode_systems.' . $phpEx);
require_once($phpbb_root_path . 'install/function_eveonline_bbcode_subsystems.' . $phpEx);

// The name of the mod to be displayed during installation.
$mod_name = 'UMIL_EVEONLINE_BBCODE';

/*
* The name of the config variable which will hold the currently installed version
* UMIL will handle checking, setting, and updating the version itself.
*/
$version_config_name = 'eveonline_bbcode_version';

/*
* The array of versions and actions within each.
* You do not need to order it a specific way (it will be sorted automatically), however, you must enter every version, even if no actions are done for it.
*
* You must use correct version numbering.  Unless you know exactly what you can use, only use X.X.X (replacing X with an integer).
* The version numbering must otherwise be compatible with the version_compare function - http://php.net/manual/en/function.version-compare.php
*/
$versions = array(
	'0.1.0'	=> array(
		'custom'	=> 'umil_eveonline_bbcode_0_1_0',
	),
);

// Include the UMIF Auto file and everything else will be handled automatically.
include($phpbb_root_path . 'umil/umil_auto.' . $phpEx);

// <editor-fold defaultstate="collapsed" desc="Functions by version">
/*
 * Functions based on version
 */
function umil_eveonline_bbcode_0_1_0($action, $version)
{
    global $db, $table_prefix, $umil;

    if ($action == 'uninstall')
    {
		umil_eveonline_bbcode_remove_database();
    }

    if ($action == 'install')
    {
        umil_eveonline_bbcode_install_database();
    }

    $umil->cache_purge();

    return 'UMIL_EVEONLINE_BBCODE_0_1_0';
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Functions for repeated use">
/*
* Function to update the EVE Online BBcode DB tables, meaning the Items, Ships and Systems from a fresh EVE DB dump.
*/
function umil_eveonline_bbcode_install_database()
{
	global $db, $table_prefix, $umil;

	// Items
	if ($umil->table_exists($table_prefix . 'eveonline_bbcode_items'))
	{
		$umil->table_remove($table_prefix . 'eveonline_bbcode_items');
	}
	$umil->table_add($table_prefix . 'eveonline_bbcode_items', array(
		'COLUMNS'		=> array(
			'itemID'		=> array('UINT:6', 0),
			'itemName'		=> array('VCHAR:100', ''),
			'categoryID'	=> array('UINT:6', 0),
		),
		'PRIMARY_KEY'	=> 'itemID',
	));

	// Ships
	if ($umil->table_exists($table_prefix . 'eveonline_bbcode_ships'))
	{
		$umil->table_remove($table_prefix . 'eveonline_bbcode_ships');
	}
	$umil->table_add($table_prefix . 'eveonline_bbcode_ships', array(
		'COLUMNS'		=> array(
			'typeID'			=> array('INT:10', 0),
			'typeName'			=> array('VCHAR:100', ''),
			'Low'				=> array('INT:2', 0),
			'Medium'			=> array('INT:2', 0),
			'High'				=> array('INT:2', 0),
			'Drone'				=> array('INT:5', 0),
			'Rig'				=> array('INT:2', 0),
			'Subsystem'			=> array('INT:2', 0),
			'raceID'			=> array('INT:2', 0),
			'raceName'			=> array('VCHAR:20', ''),
			'Tech'				=> array('VCHAR:10', ''),
			'groupName'			=> array('VCHAR:50', ''),
			'marketGroupName'	=> array('VCHAR:50', ''),
			'Icon'				=> array('VCHAR:30', ''),
		),
		'PRIMARY_KEY'	=> 'typeID',
	));

	// System
	if ($umil->table_exists($table_prefix . 'eveonline_bbcode_systems'))
	{
		$umil->table_remove($table_prefix . 'eveonline_bbcode_systems');
	}
	$umil->table_add($table_prefix . 'eveonline_bbcode_systems', array(
		'COLUMNS'		=> array(
			'systemID'		=> array('INT:11', 0),
			'systemName'	=> array('VCHAR:100', ''),
		),
		'PRIMARY_KEY'	=> 'systemID',
	));
	
	// Subsystems
	if ($umil->table_exists($table_prefix . 'eveonline_bbcode_subsystems'))
	{
		$umil->table_remove($table_prefix . 'eveonline_bbcode_subsystems');
	}
	$umil->table_add($table_prefix . 'eveonline_bbcode_subsystems', array(
		'COLUMNS'		=> array(
			'typeID'			=> array('INT:10', 0),
			'typeName'			=> array('VCHAR:100', ''),
			'Low'				=> array('INT:2', 0),
			'Medium'			=> array('INT:2', 0),
			'High'				=> array('INT:2', 0),
			'Drone'				=> array('INT:5', 0),
		),
		'PRIMARY_KEY'	=> 'typeID',
	));

	// Fill Items table with data.
	umil_eveonline_bbcode_insert_items();

	// Fill Ships table with data.
	umil_eveonline_bbcode_insert_ships();

	// Fill Systems table with data.
	umil_eveonline_bbcode_insert_systems();
	
	// Fill Subsystems table with data.
	umil_eveonline_bbcode_insert_subsystems();
}

/*
* Function to remove the EVE Online BBcode DB tables.
*/
function umil_eveonline_bbcode_remove_database()
{
	global $db, $table_prefix, $umil;

	// Items
	if ($umil->table_exists($table_prefix . 'eveonline_bbcode_items'))
	{
		$umil->table_remove($table_prefix . 'eveonline_bbcode_items');
	}

	// Ships
	if ($umil->table_exists($table_prefix . 'eveonline_bbcode_ships'))
	{
		$umil->table_remove($table_prefix . 'eveonline_bbcode_ships');
	}

	// System
	if ($umil->table_exists($table_prefix . 'eveonline_bbcode_systems'))
	{
		$umil->table_remove($table_prefix . 'eveonline_bbcode_systems');
	}
	
	// Subsystem
	if ($umil->table_exists($table_prefix . 'eveonline_bbcode_subsystems'))
	{
		$umil->table_remove($table_prefix . 'eveonline_bbcode_subsystems');
	}
}
// </editor-fold>

?>
