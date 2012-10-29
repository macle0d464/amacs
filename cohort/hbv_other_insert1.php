<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>���������� ��������� ��� HCV ����� �������������</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
//form_data2table($_GET);

//$data_array2 = prepare_data("prophylactic_therapies", $_GET);
//$names = array_keys($data_array2);
$list = array();

$meds_query = "SELECT * FROM hcv_other_meds";
$result = execute_query($meds_query);
$num_rows = mysql_num_rows($result);
for ($j=0; $j<$num_rows; $j++)
	{
    	$row = mysql_fetch_assoc($result);
        $list[$row['ID']] = $row['Name'];
	}
mysql_free_result($result);

$therapies = array();

$query = "SELECT * FROM hcv_other_treatments WHERE PatientCode=".$_GET['code'];
$result = execute_query($query);
$num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
        $has_therapy = 0;
    }
    else
    {
    	$has_therapy = 1;
        for ($j=0; $j<$num_rows; $j++)
        {
            $row = mysql_fetch_assoc($result);
            $therapies[$j]['schema'] = $row['Sxima'];
            $therapies[$j]['start'] = $row['StartDate'];
            $therapies[$j]['end'] = $row['EndDate'];
        }
    }
mysql_free_result($result);

//print_r($therapies);
//echo "<BR>Has therapy: ".$has_therapy."<BR><BR>";
    
// Parse data from FORM

$new_therapy['schema'] = $_GET['Schema'];
$new_therapy['descr'] = $list[$_GET['Schema']];
if ($_GET['StartDate_ba_year'] == "")
{
	$new_therapy['end'] = join_date($_GET, 'EndDate_ba');
	$new_therapy['start'] = "0000-00-00";
}
else if ($_GET['EndDate_ba_year'] == "")
{
	$new_therapy['start'] = join_date($_GET, 'StartDate_ba');
	$new_therapy['end'] = "3000-01-01";
}
else
{
	if (!check_dates($_GET, 'StartDate_ba', 'EndDate_ba'))
	{
		die("� ���������� ������� �������� ". $_GET['Schema'] ." ������ �� ����� ����������� ��� ���� ���� ��� ���������� ����� ���");
	}
	$new_therapy['start'] = join_date($_GET, 'StartDate_ba');
	$new_therapy['end'] = join_date($_GET, 'EndDate_ba');
}		
$new_therapy['reason'] = $_GET['Reason_ba'];
//print_r($new_therapy);


 if ($new_therapy['start'] == "0000-00-00")
 {
	$start_query = "SELECT * FROM hcv_other_treatments WHERE PatientCode='".$_GET['code']."' AND EndDate='3000-01-01' AND Sxima='".$new_therapy['schema']."'";
	$result = execute_query($start_query);
	$num_rows =	mysql_num_rows($result);
	if ($num_rows == 0)
	{
		die ("<div class='img-shadow'><p style='display: block; border: 1px solid red'>��� ��� ������ ".$_GET['code']." ��� ������� ������������ ������������ ����� <b>".$new_therapy['schema']."</b> ��� ������� ��� ���������� ������!</p></div>");
	}
	else 
	{
		$row = mysql_fetch_assoc($result);
		$start_date = $row['StartDate'];
		if ($new_therapy['end'] >= $start_date)
		{
			$new_therapy['updatequery'] = "UPDATE hcv_other_treatments SET EndDate='". $new_therapy['end'] ."', Reason='".$new_therapy['reason']."' WHERE PatientCode='".$_GET['code']."' AND Sxima='".$new_therapy['schema']."' AND StartDate='". $start_date ."'";
		}
		else 
		{
			echo "<div class='img-shadow'>";
			echo "<p style='display: block; border: 1px solid red'>";
			echo "� ���������� �������� ��� ������ (".$new_therapy['end'].") ��� �������� ".$new_therapy['schema'];
			echo "<BR>��� ������ �� ����� ���� ��� ���������� ������� ��� ".$start_date;
			echo "</div></p>";
			die();
		}

	}
 }

// Check Date Consistencies

if ($has_therapy)
{
	$trouble=0;	
		for ($j=0; $j < count($therapies); $j++)
		{
			 if ($new_therapy['start'] != "0000-00-00")
			 {
				if ($new_therapy['start'] <= $therapies[$j]['start'])
				{
					if ($new_therapy['end'] <= $therapies[$j]['start'])
					{/* echo "OK!"; */}
					else
					{ 
						echo "<div class='img-shadow'>";
						echo "<p style='display: block; border: 1px solid red'>";
						echo "&nbsp;&nbsp;&nbsp;&nbsp; <b>��������</b> ���� ���������� ��� �������� <b>".$new_therapy['descr']."</b><BR>";
						echo "������� ��� ������� �� ���������� ������� ".$therapies[$j]['start']." ��� �� ����� ".$list[$therapies[$j]['schema']];
						echo "<BR> ��� ������ �� ������������ ������� ��� �� ����� ".$new_therapy['descr']." �� ���������� ������� ".$new_therapy['start'];
						if ($new_therapy['end'] == '3000-01-01')
						{
							echo " ��� ������� ���������� �����";
						}
						else
						{
							echo " ��� ���������� ����� ".$new_therapy['end'];
						}
						$trouble = 1;
					}
					echo "</p></div>";
				}
				else
				{
					if ($new_therapy['start'] >= $therapies[$j]['end'])
					{/* echo "OK!"; */}
					else
					{ 
						echo "<div class='img-shadow'>";
						echo "<p style='display: block; border: 1px solid red'>";
						echo "&nbsp;&nbsp;&nbsp;&nbsp; <b>��������</b> ���� ���������� ��� �������� <b>".$new_therapy['descr']."</b><BR>";
						echo "������� ��� ������� �� ���������� ������� ".$therapies[$j]['start']." ��� �� ����� ".$list[$therapies[$j]['schema']];
						if ($therapies[$j]['end'] == "3000-01-01")
						{	
							echo " ��� ������� ���������� �����";
						}
						else
						{
							echo " ��� ���������� ����� ".$therapies[$j]['end'];
						}
						echo "<BR> ��� ������ �� ������������ ������� ��� �� ����� ".$new_therapy['descr']." �� ���������� ������� ".$new_therapy['start'];
						echo " ��� ���������� ����� ".$new_therapy['end']."<BR><BR>";
						$trouble = 1;
					}
					echo "</p></div>";
				}
			 
			}
		}

	if ($trouble == 1)
	{die();}
}

// Insert data into table

if ($new_therapy['start'] == "0000-00-00")
{
	execute_query($new_therapy['updatequery']);
	echo mysql_error();
}
else // if ($new_therapy['end'] == "3001-01-01")
{
	$sql = "";
	$sql = "INSERT INTO `hcv_other_treatments` ( `PatientCode` , `Sxima` , `StartDate` , `EndDate` , `Reason`)";
	$sql .= " VALUES ('".$_GET['code']."', '".$new_therapy['schema']."', '".$new_therapy['start'];
	$sql .="', '".$new_therapy['end']."', '".$new_therapy['reason']."');";
//	echo $sql;
	execute_query($sql);
	echo mysql_error();
}

mysql_close($dbconnection);
perform_post_insert_actions("hcv_other_treatments", "hcv_other_treatments?code=".$_GET['code'], "");
?>

</BODY></HTML>
