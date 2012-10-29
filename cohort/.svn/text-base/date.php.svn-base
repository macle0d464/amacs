<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

/*
$dates[0] = "2005-1-1";
$dates[1] = "2001-1-1";
$dates[2] = "1999-1-2";
$dates[3] = "1992-1-1";
$dates[4] = "1974-11-01";
$dates[5] = "2001-1-31";
*/


$query = "SELECT * FROM antiretro_new WHERE PatientCode='891' GROUP BY StartDate ASC";
$combined_medicines_query = "SELECT DISTINCT medicine FROM medicines_combined";


$result = execute_query($combined_medicines_query);
	$num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
        $combo_meds[0] = -1; 
    }
    else
    {
        for ($j=0; $j<$num_rows; $j++)
        {
            $row = mysql_fetch_array($result);
            $combo_meds[$j] = $row[0];
        }
    }
mysql_free_result($result);

$result = execute_query($query);
$num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
        $therapies[0] = -1;
    }
    else
    {
        for ($j=0; $j<$num_rows; $j++)
        {
            $row = mysql_fetch_array($result);
            $therapies[$j]['med'] = $row[2];
            $therapies[$j]['start'] = $row[4];
            $therapies[$j]['end'] = $row[5];
        }
    }
mysql_free_result($result);

if ($therapies[0] == -1)
{

$new_therapies[0]['med'] = 1;
$new_therapies[0]['start'] = "2000-1-1";
$new_therapies[0]['end'] = "2005-2-1";
$new_therapies[1]['med'] = 3;
$new_therapies[1]['start'] = "2005-1-1";
$new_therapies[1]['end'] = "2005-1-2";
$new_therapies[2]['med'] = 2;
$new_therapies[2]['start'] = "2002-1-1";
$new_therapies[2]['end'] = "2002-1-3";

for ($i=0; $i< count($new_therapies); $i++)
{
	$dates[2*$i] = $new_therapies[$i]['start'];
	$dates[2*$i+1] = $new_therapies[$i]['end'];
}

//$dates[0] = "2000-1-1";
//$dates[1] = "2005-2-1";
//$dates[2] = "2005-1-1";
//$dates[3] = "2005-1-2";
//$dates[4] = "2002-1-1";
//$dates[5] = "2002-1-3";


print_r($dates);

echo "<TABLE style='font-family: courier new'>";

for ($i=0; $i<6; $i++)
{
	echo "<TR><TD>Date: ". $dates[$i] . " &nbsp; </TD><TD>Timestamp: ". strtotime($dates[$i]) . "</TD></TR>";
}

echo "</TABLE>";

sort($dates);
reset($dates);
print_r($dates);

echo "<TABLE style='font-family: courier new'>";

for ($i=0; $i<6; $i++)
{
	echo "<TR><TD>Date: ". $dates[$i] . " &nbsp; </TD><TD>Timestamp: ". strtotime($dates[$i]) . "</TD></TR>";
}

echo "</TABLE>";

echo "<BR><BR>";

echo "<TABLE>\n";
echo "<TR>\n";
echo "</TR>\n";

for ($i=0; $i<5; $i++)
{
	$schema[$i] = "|";
	for ($j=0; $j<3; $j++)
	{
		if ($dates[$i] == $new_therapies[$j]['start'])
		{
			$schema[$i] .= $new_therapies[$j]['med'] . " / ";
		}
		if ($dates[$i] > $new_therapies[$j]['start'] && $dates[$i] <= $new_therapies[$j]['end'])
		{
			$schema[$i] .= $new_therapies[$j]['med'] . " / ";
		}		
		if ($dates[$i] >= $new_therapies[$j]['end'])
		{
			$schema[$i] = str_replace($new_therapies[$j]['med']. " / ", "", $schema[$i]);
		}
	}
	$schema[$i] = substr($schema[$i], 0, strlen($schema[$i])-3) . "|";
}

echo "</TABLE>";

print_r($new_therapies);
echo "<BR><BR>";
print_r($schema);

}
else
{

$new_therapies[0]['med'] = 1;
$new_therapies[0]['start'] = "2000-1-1";
$new_therapies[0]['end'] = "2005-2-1";
$new_therapies[1]['med'] = 3;
$new_therapies[1]['start'] = "2005-1-1";
$new_therapies[1]['end'] = "2005-1-2";
$new_therapies[2]['med'] = 2;
$new_therapies[2]['start'] = "2002-1-1";
$new_therapies[2]['end'] = "2002-1-3";

$special['med'] = 5;
$special['start'] = "";
$special['end'] = "2002-1-3";



for ($i=0; $i < count($new_therapies); $i++)
{
	for ($j=0; $j < count($therapies); $j++)
	{
		if ($new_therapies[$j]['med'] == $therapies[$i]['med'])
		{
			if ($new_therapies[$j]['start'] <= $therapies[$j]['start'])
			{
				if ($new_therapies[$j]['end'] <= $therapies[$j]['start'])
				{ echo "OK!"; }
				else
				{ 
					echo "<BR>Trouble!<BR>";
					$trouble = 1;
				}
			}
			else
			{
				if ($new_therapies[$j]['start'] >= $therapies[$j]['end'])
				{ echo "OK!"; }
				else
				{ 
					echo "<BR>Trouble!<BR>";
					$trouble = 1;
				}

			}
		}
	}
}

$special_end[0]['med'] = 9;
$special_end[0]['end'] = "2006-1-3";

for ($i=0; $i< count($special_end); $i++)
{
	$start_query = "SELECT * FROM antiretro_new WHERE PatientCode='891' AND EndDate='3000-01-01' AND Medicine='". $special_end[0]['med'] ."'";
}



for ($i=0; $i< count($new_therapies); $i++)
{
	$dates[2*$i] = $new_therapies[$i]['start'];
	$dates[2*$i+1] = $new_therapies[$i]['end'];
}
	
	
}


/*

mysql> SELECT UNIX_TIMESTAMP();
        -> 882226357
mysql> SELECT UNIX_TIMESTAMP('1997-10-04 22:23:00');
        -> 875996580

*/

mysql_close($dbconnection);
?>