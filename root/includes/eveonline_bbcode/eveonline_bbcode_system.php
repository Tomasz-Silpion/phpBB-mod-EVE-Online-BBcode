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

class System
{
	public static function getSystem($systemName)
	{
		$row = self::queryDatabase($systemName);
		
		if($row && self::isSystem($systemName))
		{
			if(isset($_SERVER['HTTP_EVE_TRUSTED']))
			{
				return self::returnHTML($row['systemID'], $row['systemName']);
			}
			else
			{
				return $row['systemName'];
			}
		}
		else
		{
			return $systemName;
		}
	}
	
	private static function queryDatabase($systemName)
	{
        global $db, $table_prefix;
		
		$sql = 'SELECT systemID, systemName
				FROM ' . $table_prefix . 'eveonline_bbcode_systems
				WHERE LOWER(systemName) = "' . $db->sql_escape(strtolower($systemName)) . '"';
        $result = $db->sql_query($sql);
        $row = $db->sql_fetchrow($result);
        $db->sql_freeresult($result);
		
		return $row;
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
	
	private static function isSystem($systemName)
	{
		if(preg_match("#([A-Za-z\- ]{3,25})#", $systemName) || preg_match("#(J[0-9]{6}[\-1]{0,2})#", $systemName) || preg_match("#([A-Za-z0-9\-]{6})#", $systemName))
		{
			return true;
		}
		
		return false;
	}
	
	private static function isWormhole($systemID)
	{
		if($systemID >= 31000000 && $systemID < 32000000)
		{
			return true;
		}
		
		return false;
	}
}

?>