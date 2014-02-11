<?php

/*
The MIT License (MIT)

Copyright (c) 2014 Cyerus

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

namespace EVEOnlineBBcode;

class Fitting
{
	public static function getFitting($fittingText)
	{
		// Create an array from the fitting and loop each row
		$fittingLines = preg_split("#\r\n|\r|\n#", $fittingText);
		
		// Declare variables used in loop
		$fittingSlotType = array(
			"Low",
			"Medium",
			"High",
			"Rig",
			"Subsystem",
			"Drone"
		);

		$eftSlotType = array(
			"low",
			"med",
			"high",
			"rig",
			"subsystem",
			"drone"
		);
		
		$defaultSlotCount = array(
			"Low"		=> 8,
			"Medium"	=> 8,
			"High"		=> 8,
			"Rig"		=> 3,
			"Subsystem"	=> 5,
			"Drone"		=> 4
		);
		
		$fittingName = "";
		$fittingArray = array();
		$slotType = 0;
		$slotCounter = 0;
		$subSystems = array();
        $tempFittingOutput = "";
        $ingameFittingLink = array();
		
		foreach($fittingLines as $key => $line)
		{
			// Fitting should start with [Shipname, Fitting Name]
			// at line 0, basically false
			if(!$key)
			{
				// Cut line into pieces to grab Ship name and fitting name
				preg_match("#^[ ]*\[([A-Za-z ]+), ([\s\S]+)\][ ]*$#", $line, $matches);
				
				// Grab information about ship
				// And return EFT output if ship isn't found
				$shipInfo = self::getShipInfo($matches[1]);
				if(!$shipInfo)
				{
					return $fittingText;
				}
				
				// Might aswell declare the fitting name
				$fittingName = $matches[2];
				
				continue;
			}
			
            // Empty lines means we need to switch to different slottype (from lowslot to midslot for example).
            if(empty($line))
            {
				if($slotCounter < $defaultSlotCount[$fittingSlotType[$slotType]])
				{
					for($slotCounter; $slotCounter < $defaultSlotCount[$fittingSlotType[$slotType]]; $slotCounter++)
					{
						$fittingArray[$fittingSlotType[$slotType]][] = false;
					}
				}                
				
				$slotType++;
                $slotCounter = 0;
				
                continue;
            }
			
			// Check if we are higher than the default number of allowed slots
			if($slotCounter >= $defaultSlotCount[$fittingSlotType[$slotType]])
			{
				continue;
			}
			
			// Continue if it's an empty slot
			if($line == "[empty " . $eftSlotType[$slotType] . " slot]")
			{
				$fittingArray[$fittingSlotType[$slotType]][] = false;
				$slotCounter++;
				
				continue;
			}
			else
			{
				// Add item to the array we'll be looping below.
				// All the junk should be weeded out by now (at least I hope so).
				$fittingArray[$fittingSlotType[$slotType]][] = trim($line);
				
				// We found a subsystem, add it to array so we can grab the slot layout later
				if($fittingSlotType[$slotType] == "Subsystem")
				{
					$subSystems[] = trim($line);
				}

				$slotCounter++;
			}
		}
		
		// Get the amount of fitting slots the Subsystems give
		if(!empty($subSystems))
		{
			$shipInfo = self::getSubsystemInfo($subSystems, $shipInfo);
		}

		// Loop each slotType
		$slotCounter = 0;
		foreach($fittingArray as $slot => $positions)
		{
			$positionCounter = 0;
			
			// Loop each slot position
			foreach($positions as $position => $row)
			{
				// Ship doesn't is out of slotPositions, so move to next slotType
				if($positionCounter >= $shipInfo[ucfirst($slot)])
				{
					break;
				}
				
				if(!$row)
				{
                    // Empty slot, so add the empty slot icon for this type of slot.
                    $tempFittingOutput .= '<div id="' . $slot . ($position + 1) . '"><img border="0" title="Empty ' . ucfirst($slot) . ' Slot" src="images/eve/' . $slot . '_32.png"></div>';
				}
				else
				{
                    // Check if the lines has a comma, meaning it probably holds ammo/script
                    if(strpos($row, ','))
                    {
                        // Split the line, creating an array with [0] holding weapon/module and [1] holding ammo/script
                        $splitRow = explode(',', $row);
                        $itemName = trim($splitRow[0]);
                        $ammoName = trim($splitRow[1]);

                        // Even though a comma might be used, there might not be anything after it.
                        if(!empty($ammoName))
                        {
                            // Search the item in the database; mainly to receive it's itemID needed for it's icon.
							$itemInfo = self::getItemInfo($itemName);

                            // No result? Item not found.
                            if(!$itemInfo)
                            {
                                $tempFittingOutput .= '<div id="' . $slot . 'charge' . ($position + 1) . '"><img border="0" title="Unrecognized item" src="images/eve/questionmark.png"></div>';
                            }
                            else
                            {
                                // Item found, so add the correct clickable icon.
                                $tempFittingOutput .= '<div id="' . $slot . 'charge' . ($position + 1) . '"><img border="0" title="' . htmlentities($itemInfo['itemName']) . '" src="http://image.eveonline.com/Type/' . $itemInfo['itemID'] . '_32.png" onclick="CCPEVE.showInfo(' . $itemInfo['itemID'] . ')"  onmouseover="this.style.cursor=\'pointer\'"></div>';
                            }
                        }
                    }
                    else
                    {
                        // No comma found, so the itemname consists of the whole line.
                        $itemName = $itemInfo;
                    }

                    // Drones can sometimes have the amount of them added behind them, like 'Ogre II x5'.
                    if($slot == 'Drone')
                    {
                        // Remove the x5 to get the correct itemname back.
                        $itemName = trim(preg_replace('/x[\d]+/', '', $itemName));
                    }

                    // After all the validation and correction, it's finally time to search for the module.
					$itemInfo = self::getItemInfo($itemName);

                    // No result? Item not found.
                    if(!$itemInfo)
                    {
                        $tempFittingOutput .= '<div id="' . $slot . ($position + 1) . '"><img border="0" title="Unrecognized item" src="images/eve/questionmark.png"></div>';
                    }
                    else
                    {
                        // Item found, so add the correct clickable icon.
                        $tempFittingOutput .= '<div id="' . $slot . ($position + 1) . '"><img border="0" title="' . htmlentities($itemInfo['itemName']) . '" src="http://image.eveonline.com/Type/' . $itemInfo['itemID'] . '_32.png" onclick="CCPEVE.showInfo(' . $itemInfo['itemID'] . ')" onmouseover="this.style.cursor=\'pointer\'"></div>';

                        // Update or reset the slot number, so the next items is placed in the next slot.
                        $stringSlot = (string) $slot;
                        if(!isset($ingameFittingLink[$stringSlot][$itemInfo['itemID']]))
                        {
                            $ingameFittingLink[$stringSlot][$itemInfo['itemID']] = 0;
                        }
                        $ingameFittingLink[$stringSlot][$itemInfo['itemID']]++;
                    }
				}
					
				$positionCounter++;
			}
			
			$slotCounter++;
		}
		
        // Start fitting
        $fitting_output = '<div id="fittitle"><h4>' . htmlentities($shipInfo['typeName']) . ' - ' . htmlentities($fittingName) . '</h4></div>';
        $fitting_output .= '<div id="fitting_container">';
        $fitting_output .= '<div class="fitting_tabs"><ul class="fit-tabs"><li class="fit-tab" onclick="chooseTab(this,\'loadout\');" onmouseover="this.style.cursor=\'pointer\'">Loadout</li><li class="fit-tab" onclick="chooseTab(this,\'export\');" onmouseover="this.style.cursor=\'pointer\'">Export</li><li class="fit-tab" onclick="ddd" onmouseover="this.style.cursor=\'pointer\'">Ingame Fitting</li></ul><div style="clear:both;"></div></div>';
        $fitting_output .= '<div id="fittext" style="display:none;"><textarea readonly="readonly">' . htmlentities(str_replace("\n", "\r", $fittingText)) . '</textarea></div>';
        $fitting_output .= '<div title="fitting" id="fitting">';

        // Fitting window
        $fitting_output .= '<div id="fittingwindow"><img border="0" alt="" src="images/eve/fitting_panel.png"></div>';
        $fitting_output .= '<div id="shiprace"><img border="0" alt="" title="' . $shipInfo['Icon'] . '" src="images/eve/races/' . $shipInfo['Icon'] . '.png"></div>';
        $fitting_output .= '<div id="shipicon"><img border="0" alt="" title="' . $shipInfo['Tech'] . ' - ' . $shipInfo['groupName'] . ' - ' . htmlentities($shipInfo['typeName']) . '" src="http://image.eveonline.com/Render/' . $shipInfo['typeID'] . '_64.png" onclick="CCPEVE.showInfo(' . $shipInfo['typeID'] . ')" onmouseover="this.style.cursor=\'pointer\'"></div>';

        // Actual fitting, whereas $temp_fitting_output is holding all the slot information looped above.
        $fitting_output .= $tempFittingOutput;

        // End fitting
        $fitting_output .= '</div></div>';
		
		return $fitting_output;
	}
	
	private static function getItemInfo($itemName)
	{
        global $db, $table_prefix;
		
		$sql = 'SELECT itemID, itemName
				FROM ' . $table_prefix . 'eveonline_bbcode_items
				WHERE LOWER(itemName) = "' . $db->sql_escape(strtolower($itemName)) . '"';
        $result = $db->sql_query($sql);
        $row = $db->sql_fetchrow($result);
        $db->sql_freeresult($result);
		
		return $row;
	}
	
	private static function getShipInfo($shipName)
	{
        global $db, $table_prefix;
		
		$sql = 'SELECT *
				FROM ' . $table_prefix . 'eveonline_bbcode_ships
				WHERE LOWER(shipName) = "' . $db->sql_escape(strtolower($shipName)) . '"';
        $result = $db->sql_query($sql);
        $row = $db->sql_fetchrow($result);
        $db->sql_freeresult($result);

		return $row;
	}
	
	private static function getSubsystemInfo($subSystems, $shipInfo)
	{
        global $db, $table_prefix;
		
		$subSystemString = "";
		foreach($subSystems as $subSystem)
		{
			$subSystemString .= "'" . $db->sql_escape(strtolower($subSystem)) . "',";
		}
		$subSystemString = substr($subSystemString, 0, -1);
		
		$sql = 'SELECT SUM(Low) as Low, SUM(Medium) as Medium, SUM(High) as High, SUM(Drone) as Drone
				FROM ' . $table_prefix . 'eveonline_bbcode_subsystems
				WHERE LOWER(typeName) IN (' . $subSystemString . ')';
        $result = $db->sql_query($sql);
        $row = $db->sql_fetchrow($result);
        $db->sql_freeresult($result);
		
		if($row)
		{
			$shipInfo['Low'] = $row['Low'];
			$shipInfo['Medium'] = $row['Medium'];
			$shipInfo['High'] = $row['High'];

			if($shipInfo['Drone'] > 0)
			{
				$shipInfo['Drone'] = 4;
			}
		}
		
		return $shipInfo;
	}
	
	private static function returnHTML($systemID, $systemName)
	{
		global $phpbb_root_path;
		
		if(!self::isWormhole($systemID))
		{
			$html =	'<a class="postlink">' . $systemName . '</a>&nbsp;&nbsp;' .
					'<img src="'.$phpbb_root_path.'/images/eveonline_bbcode/information.png" onmouseover="this.style.cursor=\'pointer\'" onclick="CCPEVE.showInfo(5, '.$systemID.')" title="Information" />&nbsp;' .
					'<img src="'.$phpbb_root_path.'/images/eveonline_bbcode/map.png" onmouseover="this.style.cursor=\'pointer\'" onclick="CCPEVE.showMap('.$systemID.')" title="Show on map" />&nbsp;';
			
			if($_SERVER['HTTP_EVE_TRUSTED'] == "Yes")
			{
				$html .=	'<img src="'.$phpbb_root_path.'/images/eveonline_bbcode/destination.png" onmouseover="this.style.cursor=\'pointer\'" onclick="CCPEVE.setDestination('.$systemID.')" title="Set as destination" />&nbsp;' . 
							'<img src="'.$phpbb_root_path.'/images/eveonline_bbcode/waypoint.png" onmouseover="this.style.cursor=\'pointer\'" onclick="CCPEVE.addWaypoint('.$systemID.')" title="Add waypoint" />&nbsp;';
			}
		}
		else
		{
			$html =	'<a class="postlink">' . $systemName . '</a>&nbsp;&nbsp;';
		}
		
		return $html;
	}
}

?>