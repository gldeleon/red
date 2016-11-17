<?php
	$menus = array();	$query = "select distinct mnu_parent from {$DBName}.menu
	where mnu_parent != 0 and mnu_show = 1 order by mnu_parent";	if($result = @mysql_query($query, $link)) {		if(@mysql_num_rows($result) > 0) {			while($row = @mysql_fetch_row($result)) {				$menus[] = $row[0];			}		}	}	foreach($menus as $item => $mid) {		echo "<div id=\"mnu".$mid."\" style=\"visibility: hidden\">";		$query = "select mnu_id, mnu_name, mnu_frame from ".$DBName.".menu		where mnu_parent = ".$mid." and mnu_show = 1 order by mnu_order";		if($result = @mysql_query($query, $link)) {
			$items = @mysql_num_rows($result);			if($items > 0) {
				$i = 1;				while($row = @mysql_fetch_row($result)) {					$fr = is_null($row[2]) ? "0" : $row[2];					$name = is_null($row[1]) ? "&nbsp;" : utf8_encode($row[1]);					$mid = is_null($row[0]) ? "0" : $row[0];
					$ultimo = ($i == $items) ? " style=\"border-bottom: 1px solid #FFF;\"" : "";					echo "<div id=\"{$mid}\" class=\"menuSubItem\"{$ultimo} onclick=\"clickMenu(this.id, '{$fr}')\">{$name}</div>\n";
					$i++;				}			}			@mysql_free_result($result);		}		echo "</div>";	}?>