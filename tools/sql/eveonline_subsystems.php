<?php

// Prepare the script to work within phpBB's environment.
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();


// Delete old eveapi_items
$sql = "DROP TABLE IF EXISTS `eveonline_subsystems`";
$db->sql_query($sql);

// Create new eveapi_items
$sql =	"CREATE TABLE `eveonline_subsystems` (
			`typeID` int(10) NOT NULL DEFAULT 0,
			`typeName` varchar(255) NOT NULL DEFAULT \"\",
			`Low` int(2) NOT NULL DEFAULT 0,
			`Medium` int(2) NOT NULL DEFAULT 0,
			`High` int(2) NOT NULL DEFAULT 0,
			`Drone` int(2) NOT NULL DEFAULT 0,
			PRIMARY KEY  (`typeID`)
		)";
$db->sql_query($sql);

// Fill new table
$sql = "INSERT INTO `eveonline_subsystems` (`typeID`, `typeName`, `Low`, `Medium`, `High`, `Drone`)
		SELECT it.typeID, it.typeName, IFNULL(low.valueInt, IFNULL(low.valueFloat,0)) AS Low, IFNULL(med.valueInt, IFNULL(med.valueFloat,0)) AS Medium, IFNULL(high.valueInt, IFNULL(high.valueFloat,0)) AS High, IFNULL(drone.valueInt, IFNULL(drone.valueFloat,0)) AS Drone
		FROM invTypes AS it
		JOIN invGroups g on it.groupID = g.groupID
		JOIN invCategories c ON c.categoryID = g.categoryID
		JOIN chrRaces r ON it.raceID = r.raceID
		JOIN invMarketGroups mg ON it.marketGroupID = mg.marketGroupID
		LEFT JOIN dgmTypeAttributes AS low ON it.typeID = low.typeID AND low.attributeID = 1376
		LEFT JOIN dgmTypeAttributes AS med ON it.typeID = med.typeID AND med.attributeID = 1375
		LEFT JOIN dgmTypeAttributes AS high ON it.typeID = high.typeID AND high.attributeID = 1374
		LEFT JOIN dgmTypeAttributes AS drone ON it.typeID = drone.typeID AND drone.attributeID = 283
		WHERE it.published = 1
		AND c.categoryId = 32";
$db->sql_query($sql);

// Manual fixes of data
manual_fix_data();

// Create output as needed by Umil
$sql = "SELECT typeID, typeName, Low, Medium, High, Drone
		FROM eveonline_subsystems
		ORDER BY typeID";
$result = $db->sql_query($sql);

echo chr(36) . "umil->table_row_insert(".chr(36)."table_prefix.'eveonline_bbcode_subsystems', array(\r\n";

while ($row = $db->sql_fetchrow($result))
{
	$typeName_fix = str_replace("'", "\'", $row['typeName']);
	
	echo "    array(\r\n";
	echo "        'typeID' => " . $row['typeID'] . ",\r\n";
	echo "        'typeName' => '" . $typeName_fix . "',\r\n";
	echo "        'Low' => " . $row['Low'] . ",\r\n";
	echo "        'Medium' => " . $row['Medium'] . ",\r\n";
	echo "        'High' => " . $row['High'] . ",\r\n";
	echo "        'Drone' => " . $row['Drone'] . "\r\n";
	echo "    ),\r\n";
}
$db->sql_freeresult($result);

echo "));\r\n";
echo "\r\n\r\nDone\r\n";


function manual_fix_data()
{
	global $db;
	
	$sql = 'UPDATE `eveonline_subsystems` SET `Drone` = 4 WHERE `Drone` > 0';
	$db->sql_query($sql);

}

?>