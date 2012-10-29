<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Ορολογικές Εξετάσεις Ασθενούς</TITLE>
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

$sql = "SELECT FTA, FTADate FROM exams_orologikes WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_exams_oro.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=exams_orologikes>";
    echo "<input type=hidden name=examtype value=FTA>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
    $i = 0;
    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        echo "<th class=result>".$field->name . "</th>";
        $i++;
    }
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
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['FTADate']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                echo "<td class=result>".$resultrow[$field->name]."</td>";
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Εξετάσεων'></p>";
        echo "</form>";
    }

$sql = "SELECT VDRL, VDRLDate FROM exams_orologikes WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_exams_oro.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=exams_orologikes>";
    echo "<input type=hidden name=examtype value=VDRL>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
    $i = 0;
    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        echo "<th class=result>".$field->name . "</th>";
        $i++;
    }
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
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['VDRLDate']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                echo "<td class=result>".$resultrow[$field->name]."</td>";
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Εξετάσεων'></p>";
        echo "</form>";
    }

$sql = "SELECT ToxoIgG, ToxoIgGDate FROM exams_orologikes WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_exams_oro.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=exams_orologikes>";
    echo "<input type=hidden name=examtype value=ToxoIgG>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
    $i = 0;
    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        echo "<th class=result>".$field->name . "</th>";
        $i++;
    }
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
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['ToxoIgGDate']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                echo "<td class=result>".$resultrow[$field->name]."</td>";
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Εξετάσεων'></p>";
        echo "</form>";
    }

$sql = "SELECT ToxoIgM, ToxoIgMDate FROM exams_orologikes WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_exams_oro.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=exams_orologikes>";
    echo "<input type=hidden name=examtype value=ToxoIgM>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
    $i = 0;
    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        echo "<th class=result>".$field->name . "</th>";
        $i++;
    }
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
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['ToxoIgMDate']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                echo "<td class=result>".$resultrow[$field->name]."</td>";
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Εξετάσεων'></p>";
        echo "</form>";
    }

$sql = "SELECT `Anti-CMVIgG`, `Anti-CMVIgGDate` FROM exams_orologikes WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_exams_oro.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=exams_orologikes>";
    echo "<input type=hidden name=examtype value=Anti-CMVIgG>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
    $i = 0;
    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        echo "<th class=result>".$field->name . "</th>";
        $i++;
    }
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
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['Anti-CMVIgGDate']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                echo "<td class=result>".$resultrow[$field->name]."</td>";
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Εξετάσεων'></p>";
        echo "</form>";
    }    

$sql = "SELECT `Anti-CMVIgM`, `Anti-CMVIgMDate` FROM exams_orologikes WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_exams_oro.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=exams_orologikes>";
    echo "<input type=hidden name=examtype value=Anti-CMVIgM>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
    $i = 0;
    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        echo "<th class=result>".$field->name . "</th>";
        $i++;
    }
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
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['Anti-CMVIgMDate']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                echo "<td class=result>".$resultrow[$field->name]."</td>";
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Εξετάσεων'></p>";
        echo "</form>";
    }    

$sql = "SELECT `HBsAg`, `HBsAgDate` FROM exams_orologikes WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_exams_oro.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=exams_orologikes>";
    echo "<input type=hidden name=examtype value=HBsAg>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
    $i = 0;
    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        echo "<th class=result>".$field->name . "</th>";
        $i++;
    }
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
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['HBsAg']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                echo "<td class=result>".$resultrow[$field->name]."</td>";
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Εξετάσεων'></p>";
        echo "</form>";
    }    

$sql = "SELECT `Anti-HBs`, `Anti-HBsDate` FROM exams_orologikes WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_exams_oro.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=exams_orologikes>";
    echo "<input type=hidden name=examtype value=Anti-HBs>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
    $i = 0;
    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        echo "<th class=result>".$field->name . "</th>";
        $i++;
    }
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
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['Anti-HBs']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                echo "<td class=result>".$resultrow[$field->name]."</td>";
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Εξετάσεων'></p>";
        echo "</form>";
    }    

$sql = "SELECT `Anti-HBc`, `Anti-HBcDate` FROM exams_orologikes WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_exams_oro.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=exams_orologikes>";
    echo "<input type=hidden name=examtype value=Anti-HBc>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
    $i = 0;
    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        echo "<th class=result>".$field->name . "</th>";
        $i++;
    }
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
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['Anti-HBc']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                echo "<td class=result>".$resultrow[$field->name]."</td>";
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Εξετάσεων'></p>";
        echo "</form>";
    }    

$sql = "SELECT `HBeAg`, `HBeAgDate` FROM exams_orologikes WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_exams_oro.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=exams_orologikes>";
    echo "<input type=hidden name=examtype value=HBeAg>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
    $i = 0;
    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        echo "<th class=result>".$field->name . "</th>";
        $i++;
    }
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
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['HBeAg']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                echo "<td class=result>".$resultrow[$field->name]."</td>";
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Εξετάσεων'></p>";
        echo "</form>";
    }    

$sql = "SELECT `Anti-HBe`, `Anti-HBeDate` FROM exams_orologikes WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_exams_oro.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=exams_orologikes>";
    echo "<input type=hidden name=examtype value=Anti-HCV>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
    $i = 0;
    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        echo "<th class=result>".$field->name . "</th>";
        $i++;
    }
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
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['Anti-HBe']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                echo "<td class=result>".$resultrow[$field->name]."</td>";
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Εξετάσεων'></p>";
        echo "</form>";
    }    

$sql = "SELECT `Anti-HCV`, `Anti-HCVDate` FROM exams_orologikes WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_exams_oro.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=exams_orologikes>";
    echo "<input type=hidden name=examtype value=Anti-HCV>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
    $i = 0;
    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        echo "<th class=result>".$field->name . "</th>";
        $i++;
    }
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
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['Anti-HCV']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                echo "<td class=result>".$resultrow[$field->name]."</td>";
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Εξετάσεων'></p>";
        echo "</form>";
    }    

$sql = "SELECT `Anti-HDV`, `Anti-HDVDate` FROM exams_orologikes WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_exams_oro.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=exams_orologikes>";
    echo "<input type=hidden name=examtype value=Anti-HDV>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
    $i = 0;
    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        echo "<th class=result>".$field->name . "</th>";
        $i++;
    }
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
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['Anti-HDV']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                echo "<td class=result>".$resultrow[$field->name]."</td>";
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Εξετάσεων'></p>";
        echo "</form>";
    }    

$sql = "SELECT `Mantoux`, `MantouxDate` FROM exams_orologikes WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_exams_oro.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=exams_orologikes>";
    echo "<input type=hidden name=examtype value=Mantoux>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
    $i = 0;
    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        echo "<th class=result>".$field->name . "</th>";
        $i++;
    }
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
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['Mantoux']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                echo "<td class=result>".$resultrow[$field->name]."</td>";
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Εξετάσεων'></p>";
        echo "</form>";
    }    
    
    
mysql_free_result($result);
mysql_close($dbconnection);
?>