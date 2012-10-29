<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
	die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

function query2dat($result, $file)
{
    $handle = fopen($file, "wb");
    $data="";
    
/*    $i = 0;
    while ($i < mysql_num_fields($result)-1)
    {
        $field = mysql_fetch_field($result, $i);
        $data .= $field->name . ";";
        $i++;
    }
    $field = mysql_fetch_field($result, $i);
    $data .= $field->name . "\n";
    fwrite($handle, $data);
    $data="";
*/
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
//        $message = $num_rows . " rows returned!";
//       fwrite($handle, $message);
    }
    else
    {
        for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            while ($i < mysql_num_fields($result)-1)
            {
                $field = mysql_fetch_field($result, $i);
                $data .= $resultrow[$field->name] . " ";
                $i++;
            }
            $field = mysql_fetch_field($result, $i);
            $data .= $resultrow[$field->name] . "\n";
            fwrite($handle, $data);
            $data="";
        }
    }
    fclose($handle);
}

?>

<HTML><HEAD>
<TITLE>CD4, HIV-RNA & ART Report</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>

<?
ob_flush();

$code = $_GET['code'];
$sql = "SELECT Name, Surname, BirthDate FROM patients WHERE PatientCode=".$code;
$result = execute_query($sql);
$row = mysql_fetch_array($result);
$name = $row[0];
$surname = $row[1];
$birthdate = $row[2];

$sql = "SELECT ExamDate, AbsoluteCD4 FROM exams_anosologikes e WHERE PatientCode=".$code;
$result = execute_query($sql);
query2dat($result, "./gnuplot/CD4.dat");

$sql = "SELECT ExamDate, LOG10(`Value`) FROM exams_iologikes e WHERE Operator!='<' AND Patientcode=".$code;
$result = execute_query($sql);
query2dat($result, "./gnuplot/RNA.dat");

//shell_exec("plot.bat");

//echo "<img src='./gnuplot/cd4rna.png'>";

// Medicines

$medicine_query = "SELECT ID,Name,Category FROM medicines";
$results = execute_query($medicine_query);		
$num = mysql_num_rows($results);
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$medicine_array[$i]['id'] = $row['ID'];
	$medicine_array[$i]['name'] = $row['Name'];
	$medicine_array[$i]['category'] = $row['Category'];
}

$reasons_query = "SELECT * FROM antiretro_reasons";
$results = execute_query($reasons_query);		
$num = mysql_num_rows($results);
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$reasons[$row['id']] = $row['description'];
}

echo "<p>&nbsp;</p>";
/*
$sql = "SELECT antiretro_treatments.medicine as medicineid, medicines.Name as Medicine, StartDate, EndDate FROM antiretro_treatments, medicines WHERE antiretro_treatments.Medicine = medicines.ID AND PatientCode=".$_GET['code'];
$result = execute_query($sql);
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
    $i = 0;
	echo "<th class=result>Φάρμακο</th>";
	echo "<th class=result>Ημερομηνία<BR>Έναρξης</th>";
	echo "<th class=result>Ημερομηνία<BR>Διακοπής</th>";
	echo "</tr>\n";
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
		echo "</table><p> &nbsp; Δεν υπάρχουν καταχωρημένα στοιχεία!</p>";
    }
    else
    {
        for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                if ($field->name != "medicineid" && $field->name != "reasonid")
                {
                	if ($field->name == "StartDate" || $field->name == "EndDate")
                	{
                		echo "<td class=result>";
                        if ($field->name == "EndDate" && $resultrow['EndDate'] == "3000-01-01")
            			{
            				echo " &nbsp;&nbsp;&nbsp; --------- ";
            			}
            			else 
            			{
            				echo show_date($resultrow[$field->name]);
            			}
                		echo "</td>";
                	}
                	else
                	{
                		echo "<td class=result>".$resultrow[$field->name]."</td>";
                	}
                }
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
    }
*/
    
$query = "SELECT antiretro_treatments.Medicine as med_id,  medicines.name as med, antiretro_treatments.StartDate as StartDate, antiretro_treatments.EndDate as EndDate FROM antiretro_treatments,medicines WHERE antiretro_treatments.PatientCode=".$_GET['code']." AND antiretro_treatments.Medicine=medicines.ID";
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
            $row = mysql_fetch_assoc($result);
            $therapies[$j]['med_id'] = $row['med_id'];
            $therapies[$j]['med'] = $row['med'];
            $therapies[$j]['start'] = $row['StartDate'];
            $therapies[$j]['end'] = $row['EndDate'];
        }
    }
mysql_free_result($result);

if ($therapies[0] == -1)
{
//	echo "<h2>Δεν υπάρχουν καταχωρημένες αντιρετροϊκές θεραπείες για τον ασθενή ".$_GET['code']."</h2>";
}
else
{
for ($i=0; $i< count($therapies); $i++)
{
	$old_dates[2*$i] = $therapies[$i]['start'];
	$old_dates[2*$i+1] = $therapies[$i]['end'];
}
$temp = array_unique($old_dates);
$old_dates = array_values($temp);
sort($old_dates);
reset($old_dates);
for ($i=0; $i < 2*count($therapies)-1; $i++)
{
	for ($j=0; $j < count($therapies); $j++)
	{
		if ($old_dates[$i] == $therapies[$j]['start'])
		{
			$old_schema[$i] .= $therapies[$j]['med'] . " / ";
		}
		if ($old_dates[$i] > $therapies[$j]['start'] && $old_dates[$i] <= $therapies[$j]['end'])
		{
			$old_schema[$i] .= $therapies[$j]['med'] . " / ";
		}		
		if ($old_dates[$i] >= $therapies[$j]['end'])
		{
			$old_schema[$i] = str_replace($therapies[$j]['med']. " / ", "", $old_schema[$i]);
		}
	}
	$old_schema[$i] = substr($old_schema[$i], 0, strlen($old_schema[$i])-3);
}
}

//$ycoord = 450;
$sql_y = "SELECT MAX(AbsoluteCD4), MIN(AbsoluteCD4) FROM exams_anosologikes WHERE PatientCode=".$code;
$result_y = execute_query($sql_y);
$row = mysql_fetch_array($result_y);
$ymax = $row[0] + 120;
$ymin = $row[1] - 30;
$ycoord = $ymax - 10;

$sql_y2 = "SELECT MAX(LOG10(`Value`)), MIN(LOG10(`Value`)) FROM exams_iologikes e WHERE Operator!='<' AND Patientcode=".$code;
$result_y2 = execute_query($sql_y2);
$row = mysql_fetch_array($result_y2);
$y2max = $row[0] + 1.8;
$y2min = $row[1]- 0.15;

// Write Plot Commands File

    $handle = fopen("./gnuplot/cd4rnathe.plt", "wb");
    $data="";
    fwrite($handle, "set terminal png nocrop enhanced truecolor font arial 12 size 1000,750 
	set output 'cd4rnathe.png'
	set style line 1 lt 1 lc rgbcolor '#273F6F' lw 1 pt 4 ps 1
	set style line 2 lt 1 lc rgbcolor '#B5444C' lw 1 pt 12 ps 1.2
	set title 'Patient $code'
	set key outside below
	set xdata time
	set timefmt '%Y-%m-%d'
	set format x '%Y'
	set x2tics mirror
	set x2data time
	set format x2 '%Y'
	set yrange [ $ymin : $ymax ]
	set y2tics 0, 0.5
	set ytics nomirror
	set y2range [ $y2min : $y2max ]
	unset autoscale y2
	set xlabel 'Years'
	set ylabel 'CD4 Count  (cells/{/Symbol m}l)'
	set y2label 'HIV-RNA  [log_{10}(copies/ml)]'\n");

//    fwrite($handle, "set parametric\n");
	for ($i=0; $i< count($old_dates)-1; $i++)
	{
		$j = $i+1;
//		echo $old_schema[$i]."&nbsp;&nbsp;&nbsp;".show_date($old_dates[$i])."<BR />";
		$data = "set label $j '".$old_schema[$i]."' at '".$old_dates[$i]."', $ycoord, 0 left rotate by 271 back textcolor lt 3 point pt 9 ps 1 offset character -0.2, -0.5, 0 font 'verdana,8'\n";
		fwrite($handle, $data);
//		$data = "const=".$old_dates[$i]."\n plot const,t\n";
//		fwrite($handle, $data);
	}
//	fwrite($handle, "unset parametric\n");
	fwrite($handle, "plot 'CD4.dat' using 1:2 axes x1y1 with linespoints linestyle 1 title 'CD4 Count', 'RNA.dat' using 1:2 axes x1y2 with linespoints linestyle 2 title 'HIV-RNA'");
	fclose($handle);

	shell_exec("plot.bat");

	echo "<img src='./gnuplot/cd4rnathe.png'>";

?>