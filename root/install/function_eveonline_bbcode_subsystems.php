<?php

// <editor-fold defaultstate="collapsed" desc="EVE Online - Subsystems">
/*
* Function to populate the Subsystems table as defined in the array.
*
*/
function umil_eveonline_bbcode_insert_subsystems()
{
	global $db, $table_prefix, $umil;
	
	$umil->table_row_insert($table_prefix.'eveonline_bbcode_subsystems', array(
		array(
			'typeID' => 29964,
			'typeName' => 'Legion Defensive - Adaptive Augmenter',
			'Low' => 1,
			'Medium' => 0,
			'High' => 1,
			'Drone' => 0
		),
		array(
			'typeID' => 29965,
			'typeName' => 'Legion Defensive - Nanobot Injector',
			'Low' => 2,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 29966,
			'typeName' => 'Legion Defensive - Augmented Plating',
			'Low' => 2,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 29967,
			'typeName' => 'Legion Defensive - Warfare Processor',
			'Low' => 1,
			'Medium' => 0,
			'High' => 1,
			'Drone' => 0
		),
		array(
			'typeID' => 29969,
			'typeName' => 'Tengu Defensive - Adaptive Shielding',
			'Low' => 0,
			'Medium' => 1,
			'High' => 1,
			'Drone' => 0
		),
		array(
			'typeID' => 29970,
			'typeName' => 'Tengu Defensive - Amplification Node',
			'Low' => 0,
			'Medium' => 2,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 29971,
			'typeName' => 'Tengu Defensive - Supplemental Screening',
			'Low' => 0,
			'Medium' => 2,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 29972,
			'typeName' => 'Tengu Defensive - Warfare Processor',
			'Low' => 0,
			'Medium' => 1,
			'High' => 1,
			'Drone' => 0
		),
		array(
			'typeID' => 29974,
			'typeName' => 'Loki Defensive - Adaptive Shielding',
			'Low' => 0,
			'Medium' => 1,
			'High' => 1,
			'Drone' => 0
		),
		array(
			'typeID' => 29975,
			'typeName' => 'Loki Defensive - Adaptive Augmenter',
			'Low' => 1,
			'Medium' => 1,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 29976,
			'typeName' => 'Loki Defensive - Amplification Node',
			'Low' => 1,
			'Medium' => 1,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 29977,
			'typeName' => 'Loki Defensive - Warfare Processor',
			'Low' => 0,
			'Medium' => 1,
			'High' => 1,
			'Drone' => 0
		),
		array(
			'typeID' => 29979,
			'typeName' => 'Proteus Defensive - Adaptive Augmenter',
			'Low' => 1,
			'Medium' => 0,
			'High' => 1,
			'Drone' => 0
		),
		array(
			'typeID' => 29980,
			'typeName' => 'Proteus Defensive - Nanobot Injector',
			'Low' => 2,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 29981,
			'typeName' => 'Proteus Defensive - Augmented Plating',
			'Low' => 2,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 29982,
			'typeName' => 'Proteus Defensive - Warfare Processor',
			'Low' => 1,
			'Medium' => 0,
			'High' => 1,
			'Drone' => 0
		),
		array(
			'typeID' => 30036,
			'typeName' => 'Legion Electronics - Energy Parasitic Complex',
			'Low' => 0,
			'Medium' => 3,
			'High' => 1,
			'Drone' => 0
		),
		array(
			'typeID' => 30038,
			'typeName' => 'Legion Electronics - Tactical Targeting Network',
			'Low' => 0,
			'Medium' => 4,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30040,
			'typeName' => 'Legion Electronics - Dissolution Sequencer',
			'Low' => 0,
			'Medium' => 4,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30042,
			'typeName' => 'Legion Electronics - Emergent Locus Analyzer',
			'Low' => 0,
			'Medium' => 3,
			'High' => 1,
			'Drone' => 0
		),
		array(
			'typeID' => 30046,
			'typeName' => 'Tengu Electronics - Obfuscation Manifold',
			'Low' => 0,
			'Medium' => 4,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30048,
			'typeName' => 'Tengu Electronics - CPU Efficiency Gate',
			'Low' => 1,
			'Medium' => 3,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30050,
			'typeName' => 'Tengu Electronics - Dissolution Sequencer',
			'Low' => 1,
			'Medium' => 3,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30052,
			'typeName' => 'Tengu Electronics - Emergent Locus Analyzer',
			'Low' => 0,
			'Medium' => 4,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30056,
			'typeName' => 'Proteus Electronics - Friction Extension Processor',
			'Low' => 1,
			'Medium' => 3,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30058,
			'typeName' => 'Proteus Electronics - CPU Efficiency Gate',
			'Low' => 1,
			'Medium' => 3,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30060,
			'typeName' => 'Proteus Electronics - Dissolution Sequencer',
			'Low' => 1,
			'Medium' => 3,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30062,
			'typeName' => 'Proteus Electronics - Emergent Locus Analyzer',
			'Low' => 1,
			'Medium' => 3,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30066,
			'typeName' => 'Loki Electronics - Immobility Drivers',
			'Low' => 1,
			'Medium' => 3,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30068,
			'typeName' => 'Loki Electronics - Tactical Targeting Network',
			'Low' => 0,
			'Medium' => 4,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30070,
			'typeName' => 'Loki Electronics - Dissolution Sequencer',
			'Low' => 1,
			'Medium' => 3,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30072,
			'typeName' => 'Loki Electronics - Emergent Locus Analyzer',
			'Low' => 0,
			'Medium' => 4,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30076,
			'typeName' => 'Legion Propulsion - Chassis Optimization',
			'Low' => 1,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30078,
			'typeName' => 'Legion Propulsion - Fuel Catalyst',
			'Low' => 1,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30080,
			'typeName' => 'Legion Propulsion - Wake Limiter',
			'Low' => 1,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30082,
			'typeName' => 'Legion Propulsion - Interdiction Nullifier',
			'Low' => 0,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30086,
			'typeName' => 'Tengu Propulsion - Intercalated Nanofibers',
			'Low' => 1,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30088,
			'typeName' => 'Tengu Propulsion - Gravitational Capacitor',
			'Low' => 1,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30090,
			'typeName' => 'Tengu Propulsion - Fuel Catalyst',
			'Low' => 1,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30092,
			'typeName' => 'Tengu Propulsion - Interdiction Nullifier',
			'Low' => 0,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30096,
			'typeName' => 'Proteus Propulsion - Wake Limiter',
			'Low' => 1,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30098,
			'typeName' => 'Proteus Propulsion - Localized Injectors',
			'Low' => 1,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30100,
			'typeName' => 'Proteus Propulsion - Gravitational Capacitor',
			'Low' => 0,
			'Medium' => 1,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30102,
			'typeName' => 'Proteus Propulsion - Interdiction Nullifier',
			'Low' => 0,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30106,
			'typeName' => 'Loki Propulsion - Chassis Optimization',
			'Low' => 1,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30108,
			'typeName' => 'Loki Propulsion - Intercalated Nanofibers',
			'Low' => 1,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30110,
			'typeName' => 'Loki Propulsion - Fuel Catalyst',
			'Low' => 1,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30112,
			'typeName' => 'Loki Propulsion - Interdiction Nullifier',
			'Low' => 0,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30117,
			'typeName' => 'Legion Offensive - Drone Synthesis Projector',
			'Low' => 0,
			'Medium' => 1,
			'High' => 5,
			'Drone' => 4
		),
		array(
			'typeID' => 30118,
			'typeName' => 'Legion Offensive - Assault Optimization',
			'Low' => 1,
			'Medium' => 0,
			'High' => 5,
			'Drone' => 0
		),
		array(
			'typeID' => 30119,
			'typeName' => 'Legion Offensive - Liquid Crystal Magnifiers',
			'Low' => 1,
			'Medium' => 0,
			'High' => 5,
			'Drone' => 0
		),
		array(
			'typeID' => 30120,
			'typeName' => 'Legion Offensive - Covert Reconfiguration',
			'Low' => 0,
			'Medium' => 1,
			'High' => 5,
			'Drone' => 0
		),
		array(
			'typeID' => 30122,
			'typeName' => 'Tengu Offensive - Accelerated Ejection Bay',
			'Low' => 0,
			'Medium' => 1,
			'High' => 5,
			'Drone' => 0
		),
		array(
			'typeID' => 30123,
			'typeName' => 'Tengu Offensive - Rifling Launcher Pattern',
			'Low' => 0,
			'Medium' => 1,
			'High' => 5,
			'Drone' => 4
		),
		array(
			'typeID' => 30124,
			'typeName' => 'Tengu Offensive - Magnetic Infusion Basin',
			'Low' => 0,
			'Medium' => 1,
			'High' => 5,
			'Drone' => 0
		),
		array(
			'typeID' => 30125,
			'typeName' => 'Tengu Offensive - Covert Reconfiguration',
			'Low' => 0,
			'Medium' => 1,
			'High' => 5,
			'Drone' => 0
		),
		array(
			'typeID' => 30127,
			'typeName' => 'Proteus Offensive - Dissonic Encoding Platform',
			'Low' => 1,
			'Medium' => 0,
			'High' => 5,
			'Drone' => 0
		),
		array(
			'typeID' => 30128,
			'typeName' => 'Proteus Offensive - Hybrid Propulsion Armature',
			'Low' => 1,
			'Medium' => 0,
			'High' => 5,
			'Drone' => 4
		),
		array(
			'typeID' => 30129,
			'typeName' => 'Proteus Offensive - Drone Synthesis Projector',
			'Low' => 1,
			'Medium' => 0,
			'High' => 5,
			'Drone' => 4
		),
		array(
			'typeID' => 30130,
			'typeName' => 'Proteus Offensive - Covert Reconfiguration',
			'Low' => 1,
			'Medium' => 0,
			'High' => 5,
			'Drone' => 0
		),
		array(
			'typeID' => 30132,
			'typeName' => 'Loki Offensive - Turret Concurrence Registry',
			'Low' => 1,
			'Medium' => 0,
			'High' => 5,
			'Drone' => 0
		),
		array(
			'typeID' => 30133,
			'typeName' => 'Loki Offensive - Projectile Scoping Array',
			'Low' => 1,
			'Medium' => 0,
			'High' => 5,
			'Drone' => 4
		),
		array(
			'typeID' => 30134,
			'typeName' => 'Loki Offensive - Hardpoint Efficiency Configuration',
			'Low' => 1,
			'Medium' => 0,
			'High' => 5,
			'Drone' => 4
		),
		array(
			'typeID' => 30135,
			'typeName' => 'Loki Offensive - Covert Reconfiguration',
			'Low' => 1,
			'Medium' => 0,
			'High' => 5,
			'Drone' => 0
		),
		array(
			'typeID' => 30139,
			'typeName' => 'Tengu Engineering - Power Core Multiplier',
			'Low' => 2,
			'Medium' => 0,
			'High' => 1,
			'Drone' => 0
		),
		array(
			'typeID' => 30141,
			'typeName' => 'Tengu Engineering - Augmented Capacitor Reservoir',
			'Low' => 2,
			'Medium' => 0,
			'High' => 1,
			'Drone' => 0
		),
		array(
			'typeID' => 30143,
			'typeName' => 'Tengu Engineering - Capacitor Regeneration Matrix',
			'Low' => 3,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30145,
			'typeName' => 'Tengu Engineering - Supplemental Coolant Injector',
			'Low' => 3,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30149,
			'typeName' => 'Proteus Engineering - Power Core Multiplier',
			'Low' => 2,
			'Medium' => 0,
			'High' => 1,
			'Drone' => 0
		),
		array(
			'typeID' => 30151,
			'typeName' => 'Proteus Engineering - Augmented Capacitor Reservoir',
			'Low' => 2,
			'Medium' => 0,
			'High' => 1,
			'Drone' => 4
		),
		array(
			'typeID' => 30153,
			'typeName' => 'Proteus Engineering - Capacitor Regeneration Matrix',
			'Low' => 2,
			'Medium' => 1,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30155,
			'typeName' => 'Proteus Engineering - Supplemental Coolant Injector',
			'Low' => 2,
			'Medium' => 1,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30159,
			'typeName' => 'Loki Engineering - Power Core Multiplier',
			'Low' => 2,
			'Medium' => 0,
			'High' => 1,
			'Drone' => 0
		),
		array(
			'typeID' => 30161,
			'typeName' => 'Loki Engineering - Augmented Capacitor Reservoir',
			'Low' => 2,
			'Medium' => 0,
			'High' => 1,
			'Drone' => 0
		),
		array(
			'typeID' => 30163,
			'typeName' => 'Loki Engineering - Capacitor Regeneration Matrix',
			'Low' => 2,
			'Medium' => 1,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30165,
			'typeName' => 'Loki Engineering - Supplemental Coolant Injector',
			'Low' => 2,
			'Medium' => 1,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30169,
			'typeName' => 'Legion Engineering - Power Core Multiplier',
			'Low' => 2,
			'Medium' => 0,
			'High' => 1,
			'Drone' => 0
		),
		array(
			'typeID' => 30171,
			'typeName' => 'Legion Engineering - Augmented Capacitor Reservoir',
			'Low' => 2,
			'Medium' => 0,
			'High' => 1,
			'Drone' => 0
		),
		array(
			'typeID' => 30173,
			'typeName' => 'Legion Engineering - Capacitor Regeneration Matrix',
			'Low' => 3,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
		array(
			'typeID' => 30175,
			'typeName' => 'Legion Engineering - Supplemental Coolant Injector',
			'Low' => 3,
			'Medium' => 0,
			'High' => 0,
			'Drone' => 0
		),
	));
}
// </editor-fold>

?>
