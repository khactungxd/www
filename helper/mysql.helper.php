<?php

// GET THE FIRST VALUE FOR (RECORD, COLUMN NAME)
function mysql_get_first_value($query,$columnName){	
	$result=mysql_query($query);
	if ($line=mysql_fetch_object($result))	
		return $line->$columnName;
	else
		return NULL;
}

// GET THE FIRST RECORD AS AN OBJECT
function mysql_get_first_record($query){	
	$result=mysql_query($query);
	if ($result){
		if ($line=mysql_fetch_object($result)){
			return $line;
		} else {
			//echo "<br>Err on: <br><b>".$query."</b><br>".mysql_error()."<br>";
			return NULL;
		}
	}
}

// GET ALL RECORDS AS AN ARRAY (of object)
function mysql_get_records($query){	
	$result=mysql_query($query);
	if ($result){
		$arr=array();	
		while ($line=mysql_fetch_object($result)){	
			$arr[]=$line;
		}
		return $arr;
	}
}

// GET NUMBER OF RECORDS FOR A QUERY
function mysql_get_nRecords($query){	
	$result=mysql_query($query);
	if ($result){
		$count=0;
		while ($line=mysql_fetch_object($result)){
			$count++;
		}
		return $count;
	} else {
		echo "<br>Error mysql on '".$query."'<br>";
	}
	
	return 0;
}
?>