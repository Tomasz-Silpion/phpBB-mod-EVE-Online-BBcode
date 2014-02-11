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

class Item
{
	public static function getItem($itemName)
	{
		$row = self::queryDatabase($itemName);
		
		if($row && isset($_SERVER['HTTP_EVE_TRUSTED']))
		{
			return self::returnHTML($row['itemID'], $row['itemName']);
		}
		else
		{
			return $itemName;
		}
	}
	
	private static function queryDatabase($itemName)
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
	
	private static function returnHTML($itemID, $itemName)
	{
		global $phpbb_root_path;
		
		return	'<a class="postlink">'.$itemName.'</a>&nbsp;&nbsp;' .
				'<img src="'.$phpbb_root_path.'/images/eveonline_bbcode/information.png" onmouseover="this.style.cursor=\'pointer\'" onclick="CCPEVE.showInfo('.$itemID.')" title="Information" />&nbsp;' .
				'<img src="'.$phpbb_root_path.'/images/eveonline_bbcode/market.png" onmouseover="this.style.cursor=\'pointer\'" onclick="CCPEVE.showMarketDetails('.$itemID.')" title="Market details" />&nbsp;' .
				'<img src="'.$phpbb_root_path.'/images/eveonline_bbcode/preview.png" onmouseover="this.style.cursor=\'pointer\'" onclick="CCPEVE.showPreview('.$itemID.')" title="Preview" />&nbsp;';
	}
}

?>