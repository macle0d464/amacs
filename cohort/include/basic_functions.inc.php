<?php
include_once "Spreadsheet/Excel/Writer.php";

function perform_post_insert_actions($table, $url, $extra)
{
	header("Location: $url");
}

function show_entries($page, $options)
{
	echo "<input type='button' style='border: 1px outset;' value='Προβολή Καταχωρήσεων' onclick='toggle_entries();'/>";
}

function print_options($number)
{
	for ($i=1; $i< $number+1; $i++)
	{
		if ($i<10)
		{
			echo "<OPTION VALUE='0".$i."'>".$i."</OPTION>";
		}
		else
		{
			echo "<OPTION VALUE='".$i."'>".$i."</OPTION>";
		}
	}
}

function print_options2($number)
{
	for ($i=1; $i< $number+1; $i++)
	{
		if ($i<10)
		{
			echo "<OPTION VALUE='".$i."'>".$i."</OPTION>";
		}
		else
		{
			echo "<OPTION VALUE='".$i."'>".$i."</OPTION>";
		}
	}
}

function print_opts($number)
{
	for ($i=1; $i< $number+1; $i++)
	{
		echo "<OPTION VALUE='".$i."'>".$i."</OPTION>";
	}
}

function print_years()
{
	$todays_date = getdate();
	$year = $todays_date['year'];
	$first_year = "1970";
	$year_order = "reverse";
	if ($year_order == "reverse")
	{
		for ($i=$year; $i > $first_year-1; $i--)
		{
			echo "<OPTION VALUE='".$i."'>".$i."</OPTION>";
		}
	}
	else
	{
		for ($i = $first_year; $i < $year+1; $i++)
		{
			echo "<OPTION VALUE='".$i."'>".$i."</OPTION>";
		}
	}
	echo "</SELECT>";
}

function print_years2()
{
	$todays_date = getdate();
	$year = $todays_date['year'];
	$first_year = "1970";
	$year_order = "reverse";
	if ($year_order == "reverse")
	{
		for ($i=$year; $i > $first_year-1; $i--)
		{
			echo "<OPTION VALUE='".$i."'>".$i."</OPTION>";
		}
	}
	else
	{
		for ($i = $first_year; $i < $year+1; $i++)
		{
			echo "<OPTION VALUE='".$i."'>".$i."</OPTION>";
		}
	}
}

function print_years_no_unknown()
{
	$todays_date = getdate();
	$year = $todays_date['year'];
	$first_year = "1920";
	$year_order = "reverse";
	if ($year_order == "reverse")
	{
		for ($i=$year; $i > $first_year-1; $i--)
		{
			echo "<OPTION VALUE='".$i."'>".$i."</OPTION>";
		}
	}
	else
	{
		for ($i = $first_year; $i < $year+1; $i++)
		{
			echo "<OPTION VALUE='".$i."'>".$i."</OPTION>";
		}
	}
	echo "</SELECT>";
}

function retyear($str)
{
	return substr($str, 0, 4);
}

function retmonth($str)
{
	return substr($str, 5, 2);
}

function retday($str)
{
	return substr($str, 8, 2);
}

function show_date($str)
{
	return retday($str)."/".retmonth($str)."/".retyear($str);
}

function show_dec($str)
{
	if ($str == "")
	{
		return $str;
	}
	$test = $str;
	$test = $test + 0.0;
	$test = $test."";
	$test = str_replace(".", ",", $test);
	return $test;
}

function replace2null($sql)
{
	return str_replace("''", "NULL", $sql);
}

function replacecomma($sql)
{
	return str_replace(",", ".", $sql);
}

function print_birth_years()
{
	$todays_date = getdate();
	$year = $todays_date['year'];
	$birth_year = "1900";
	$year_order = "reverse";
	if ($year_order == "reverse")
	{
		for ($i=$year; $i > $birth_year-1; $i--)
		{
			echo "<OPTION VALUE='".$i."'>".$i."</OPTION>";
		}
	}
	else
	{
		for ($i = $birth_year; $i < $year+1; $i++)
		{
			echo "<OPTION VALUE='".$i."'>".$i."</OPTION>";
		}
	}
	echo "</SELECT>";
}

function delete_from_table($patient, $table)
{
	$delete_query = "DELETE FROM `$table` WHERE PatientCode='$patient'";
	execute_query($delete_query);
}

function show_errormsg($errormsg)
{
//	$url = "http://localhost/cohort/" . $form . "?" . "error=" . $error. "&errnum=" . $errornumber . "&" . $extra;
//	header("Location: " . $url);
	echo $errormsg;
	echo "<p><a href='javascript:(history.back(-1));'>Κάντε click εδώ για επιστροφή</a>";
	exit;
}

function PrintTopMenu()
{
	echo "<SCRIPT LANGUAGE='JavaScript' SRC='JSCookMenu/JSCookMenu.js'></SCRIPT>\n";
	echo "<LINK REL='stylesheet' HREF='JSCookMenu/ThemeOffice/theme.css' TYPE='text/css'>\n";
	echo "<SCRIPT LANGUAGE='JavaScript' SRC='JSCookMenu/ThemeOffice/theme.js'></SCRIPT></HEAD>\n";
	echo "<BODY>\n";
	echo "<div style='height: 20px; position: absolute; left: 30px; top: 10px'>";
//	echo "<DIV ID='CohortMenu' style='width: 130px; border: 2px solid #fb7922;'></DIV></DIV>\n";
	echo "<DIV class='menu-shadow'><DIV ID='CohortMenu' class='menu-shadow-inner'></DIV></DIV></DIV>\n";	
	echo "<SCRIPT LANGUAGE='JavaScript' SRC='JSCookMenu/draw_top_menu.js.php'></SCRIPT>\n";
// old color #0A86AA
}

function PrintMinMenu()
{
	echo "<SCRIPT LANGUAGE='JavaScript' SRC='JSCookMenu/JSCookMenu.js'></SCRIPT>\n";
	echo "<LINK REL='stylesheet' HREF='JSCookMenu/ThemeOffice/theme.css' TYPE='text/css'>\n";
	echo "<SCRIPT LANGUAGE='JavaScript' SRC='JSCookMenu/ThemeOffice/theme.js'></SCRIPT></HEAD>\n";
	echo "<BODY>\n";
	echo "<div style='height: 20px; position: absolute; left: 30px; top: 10px'>";
//	echo "<DIV ID='CohortMenu' style='width: 130px; border: 2px solid #fb7922;'></DIV></DIV>\n";
	echo "<DIV class='menu-shadow'><DIV ID='CohortMenu' class='menu-shadow-inner'></DIV></DIV></DIV>\n";	
	echo "<SCRIPT LANGUAGE='JavaScript' SRC='JSCookMenu/draw_min_menu.js'></SCRIPT>\n";
// old color #0A86AA
}

function PrintMenu()
{
	echo "<SCRIPT LANGUAGE='JavaScript' SRC='JSCookMenu/JSCookMenu.js'></SCRIPT>\n";
	echo "<LINK REL='stylesheet' HREF='JSCookMenu/ThemeOffice/theme.css' TYPE='text/css'>\n";
	echo "<SCRIPT LANGUAGE='JavaScript' SRC='JSCookMenu/ThemeOffice/theme.js'></SCRIPT></HEAD>\n";
	echo "<BODY>\n";
//	echo "<div style='width: 900px; height: 20px; background-color:#fb7922; position: absolute; left: 30px; top: 10px'>";
//	echo "<DIV ID='CohortMenu' style='position: relative; left:2; top:2;'></DIV></div>\n";
//	echo "<DIV style='position: absolute; left:557px; top:10px; background-color: #f8e8a0; height: 20px; width: 400px'></DIV>\n";
	echo "<div style='height: 20px; position: absolute; left: 30px; top: 10px'>";
	echo "<DIV class='menu-shadow'><DIV ID='CohortMenu' class='menu-shadow-inner'></DIV></DIV></DIV>\n";	
	echo "<SCRIPT LANGUAGE='JavaScript' SRC='JSCookMenu/draw_menu.js.php'></SCRIPT>\n";
// old color #0A86AA
}

function Print_PatientCode_form($action)
{
?>
	<FORM action="<? echo $action ?>" method="GET">
	<TABLE style="position: absolute; left: 50px">
    <TR>
    <TD> Δώστε τον Κωδικό Ασθενή του ασθενή &nbsp;&nbsp;&nbsp;
    <INPUT maxLength=7 size=10 name="code">
    <img src="./images/b_help.png" style="cursor: default" onclick="window.open('./find_patient.php?field=code>', 'Ασθενείς', 'width=500,height=600,scrollbars=yes');"/>
    </TD><TD></TD>
    <TD> <input type=submit value="Αποστολή"></TD>
    <TD></TD><TD></TD>
    </TR>
	</TABLE>
	</FORM>
<?
}

function print_stored_date($value, $table)
{
	echo "document.all['".$value."_year'].value = '".retyear($table[$value])."';\n";
	echo "document.all['".$value."_month'].value = '".retmonth($table[$value])."';\n";
	echo "document.all['".$value."_day'].value = '".retday($table[$value])."';\n";
}

function print_stored_date2($value, $table_item)
{
	echo "document.all['".$value."_year'].value = '".retyear($table_item)."';\n";
	echo "document.all['".$value."_month'].value = '".retmonth($table_item)."';\n";
	echo "document.all['".$value."_day'].value = '".retday($table_item)."';\n";
}

function print_stored_check($value, $table)
{
	if ($table[$value] == 1)
	{
		echo "document.all['".$value."'].checked = true;\n";
	}
}

function print_stored_data($value, $table)
{
	echo "document.all['".$value."'].value = '".$table[$value]."';\n";
}

function print_stored_data2($value, $table_item)
{
	echo "document.all['".$value."'].value = '".$table_item."';\n";
}

function print_state_c($value, $table)
{
	if ($table[$value] == "1")
	{
		echo "document.all['".$value."1'].checked = true;\n";
	}
	if ($table[$value] == "2")
	{
		echo "document.all['".$value."2'].checked = true;\n";
	}
	echo "document.all['".$value."Date_year'].value = '".retyear($table[$value.'Date'])."';\n";
	echo "document.all['".$value."Date_month'].value = '".retmonth($table[$value.'Date'])."';\n";
	echo "document.all['".$value."Date_day'].value = '".retday($table[$value.'Date'])."';\n";

}

function PrintMenu2()
{
	echo '<style type="text/css" title="stylesheet.css">';
	echo '@import "/menu/menu.css";';
	echo '</style>';
	echo '<script src="/menu/menubarAPI4.js" type="text/javascript"></script>
	<script src="/menu/init.js" type="text/javascript"></script>';
	echo "<BODY onload=\"init();monitor=document.getElementById('mon')\">";
}

function PrintHeaders()
{
    echo "<html>\n";
    echo "<head>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"./include/original.css\" />\n";
    echo "</head><body>\n";
}

function CloseHTML()
{
    echo "</body></html>";
}


function cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password)
{
    $dbcnx = @mysql_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
    if (!$dbcnx)
    {
        echo( "<P>Unable to connect to the COHORT database server at this time.</P>" );
        exit();
    }
    return $dbcnx;
}

function cohortdb_connect2()
{
    $dbcnx = @mysql_connect($GLOBALS['cohort_db_server'], $GLOBALS['cohort_db_username'], $GLOBALS['cohort_db_password']);
    if (!$dbcnx)
    {
        echo( "<P>Unable to connect to the COHORT database server at this time.</P>" );
        exit();
    }
    return $dbcnx;
}


function cohortdb_select($dbconnection)
{
	$dbselected = mysql_select_db($GLOBALS['cohort_db_name'], $dbconnection);
	if (!$dbselected) 
	{
   		die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
	}
	return $dbselected;
}

function execute_query($str_query)
{
    $result = mysql_query($str_query);
/*    if (!$result)
    {
        echo("<P>Error performing query: " . mysql_error() . "</P>");
    }*/
    return $result;
}

function handle_query_results($table, $msg, $data)
{
	if ($table == "patients")
	{
		if (strpos($msg, "key 1"))
		{
			echo "<TABLE width=600><TR><TD>";
			echo "O κωδικός ασθενή που θέλετε να καταχωρήσετε υπάρχει <b>ήδη</b> στην βάση δεδομένων. ";
			echo "Αν συμπληρώσατε μόνο το πεδίο Κωδικός ΜΕΛ, τότε ο κωδικός αυτός συμπίπτει με έναν ήδη ";
			echo "καταχωρημένο κωδικό ασθενή της βάσης.<BR><b><font color=red>Επικοινωνήστε με το ΚΕΕΛ για να πάρετε ένα μοναδικό κωδικό ασθενή.</b></font>";
			$start = strpos($msg, "'");
			$length = 1;
			while (is_numeric(substr($msg, $start+1, $length)))
			{ $length++; }
			$ptcode = substr($msg, $start+1, $length-1);
			$patient = execute_query("SELECT * FROM patients WHERE PatientCode=".$ptcode);
			$row = mysql_fetch_assoc($patient);
			mysql_free_result($patient);
			echo "<BR>Ασθενής <b>ήδη</b> καταχωρημένος με ίδιο Κωδικό Ασθενή:";
			echo "<TABLE><TR><TD>Κωδικός Ασθενή: </TD><TD>".$row['PatientCode']."</TD>\n";
			echo "</TR><TR><TD>'Ονομα: </TD><TD>".$row['Name']."</TD>\n";
			echo "</TR><TR><TD>Επώνυμο: </TD><TD>".$row['Surname']."</TD>\n";
			echo "</TR><TR><TD>Ημερομηνία Γέννησης: </TD><TD>".$row['BirthDate']."</TD></TR></TABLE>\n";
			echo "</TR></TD></TABLE>";
		}
		if (strpos($msg, "key 2"))
		{
			echo "<TABLE width=550><TR><TD>";
			echo "Τα όνομα, επώνυμο και ημερομηνία γέννησης που θέλετε να καταχωρήσετε υπάρχουν <b>ήδη</b> στην βάση δεδομένων";
			echo " με άλλο κωδικό ασθενή. Συγκεκριμένα τα στοιχεία που είναι καταχωρημένα είναι τα εξής:";
			$patient = execute_query("SELECT * FROM patients WHERE Name='".$data['Name']."' AND Surname='".$data['Surname']."' AND BirthDate='".$data['BirthDate']."'");
			$row = mysql_fetch_assoc($patient);
			mysql_free_result($patient);
			echo "<BR>Ασθενής <b>ήδη</b> καταχωρημένος με ίδιο Κωδικό Ασθενή:";
			echo "<TABLE><TR><TD>Κωδικός Ασθενή: </TD><TD>".$row['PatientCode']."</TD>\n";
			echo "</TR><TR><TD>'Ονομα: </TD><TD>".$row['Name']."</TD>\n";
			echo "</TR><TR><TD>Επώνυμο: </TD><TD>".$row['Surname']."</TD>\n";
			echo "</TR><TR><TD>Ημερομηνία Γέννησης: </TD><TD>".$row['BirthDate']."</TD></TR></TABLE>\n";
			echo "</TR></TD></TABLE>";
			echo "Ασθενής <b>που θέλετε</b> να καταχωρήσετε: ";
			echo "<TABLE><TR><TD>Κωδικός Ασθενή: </TD><TD>".$data['PatientCode']."</TD>\n";
			echo "</TR><TR><TD>'Ονομα: </TD><TD>".$data['Name']."</TD>\n";
			echo "</TR><TR><TD>Επώνυμο: </TD><TD>".$data['Surname']."</TD>\n";
			echo "</TR><TR><TD>Ημερομηνία Γέννησης: </TD><TD>".$data['BirthDate']."</TD></TR></TABLE>\n";
			echo "</TR></TD></TABLE>";
			echo "</TR></TD></TABLE>";
		}
	}
	echo "<p>Κάντε click <a href='javascript:(history.back(-1));'>εδώ</a> για να επιστρέψετε και να κάνετε διορθώσεις στην φόρμα</p>";
}

function insert_data($table, $data_array)
{

    validate_data($table, $data_array);
    $data_array2 = prepare_data($table, $data_array);
    
    $names = array_keys($data_array2);
    
    $sql = "INSERT INTO `" . $table . "` ( ";
    for ($i=0; $i<count($data_array2)-1; $i++)
    {
        $sql .= "`" . $names[$i] . "` , ";
    }
    $sql .= "`" . $names[$i] . "` ) VALUES ( ";
    for ($i=0; $i<count($data_array2)-1; $i++)
    {
        $sql .= "'" . $data_array2[$names[$i]] . "' , ";
    }
    $sql .= "'" . $data_array2[$names[$i]] . "' );";
	echo $sql;
    return execute_query($sql);
}

function form_data2table($result)
{
    echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
    $i = 0;
    $temp_array = array_keys($result);
    while ($i < count($temp_array))
    {
        echo "<th style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>";
        echo $temp_array[$i] . "</th>";
        $i++;
    }
    echo "<tr>\n";
    $i = 0;
    while ($i < count($result))
    {
        echo "<td style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>";
        echo $result[$temp_array[$i]] . "</td>";
        $i++;
    }
    echo "</tr>\n";
    echo "</table>";
}

function query2table($result)
{
    echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
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
		echo "</table><p> &nbsp; ".$num_rows." rows returned!</p>";
    	//        echo "<tr><td>".$num_rows." rows returned!</tr></td>";
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
                echo "<td class=result>".$resultrow[$field->name]."</td>";
                $i++;
            }
            echo "</tr>\n";
        }
    }
    echo "</table>";
}

function query2quick_table($result)
{
    echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
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
		echo "</table><p> &nbsp; ".$num_rows." rows returned!</p>";
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
                echo "<td align=center class=result>";
                if ($resultrow[$field->name] == 0)
                {
                	echo " OXI ";
                }
                else if ($resultrow[$field->name] ==1)
                {
                	echo " NAI ";
                }
                else
                {
                	echo $resultrow[$field->name];
                }
                echo "</td>";
                $i++;
            }
            echo "</tr>\n";
        }
    }
    echo "</table>";
}

function draw_table($result)
{
    echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
    echo "<th class=result>Κωδικός Ασθενή</th>";
	echo "<th class=result>'Ονομα</th>";
	echo "<th class=result>Επώνυμο</th>";	
	echo "<th class=result>Ημερομηνία<BR>Γέννησης</th>";
	echo "<th class=result>Τελευταία επίσκεψη<BR>στην κλινική</th>";	
    echo "</tr>\n";
    $num_rows = mysql_num_rows($result);
        for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
            echo "<td align=center class=result>";
			echo "<a href='intermediate.php?code=".$resultrow['PatientCode']."'>".$resultrow['PatientCode']."</a>";            
//            echo $resultrow['PatientCode'];
            echo "</td>";
            echo "<td align=center class=result>";
            echo $resultrow['Name'];
            echo "</td>";
            echo "<td align=center class=result>";
            echo $resultrow['Surname'];
            echo "</td>";
            echo "<td align=center class=result>";
            echo show_date($resultrow['BirthDate']);
            echo "</td>";
            echo "<td align=center class=result>";
            echo show_date($resultrow['MAX(DateOfVisit)']);
            echo "</td>";                                                
            echo "</tr>\n";
        }
    echo "</table>";
}

function query2csv($result, $file)
{
    $handle = fopen($file, "wb");
    $data="";
    
    $i = 0;
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
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
        $message = $num_rows . " rows returned!";
        fwrite($handle, $message);
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
                $data .= $resultrow[$field->name] . ";";
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

function query2xls($result, $method)
{ 
    if ($method == "download")
    {
        $workbook =& new Spreadsheet_Excel_Writer();
        $workbook->send("query.xls");
    }
    else
    {
        $workbook =& new Spreadsheet_Excel_Writer($method);
    }
    
    $sheet =& $workbook->addWorksheet('Query Result');
 
    $format_header_row =& $workbook->addFormat();
    $format_header_row->setTop(1);
    $format_header_row->setLeft(1);
    $format_header_row->setBottom(1);
    $format_header_row->setPattern(1);
    $format_header_row->setBorderColor('black');
    $format_header_row->setFgColor(31);
    $format_header_row->setBold();
    $format_header_row->setShadow();

    $format_data =& $workbook->addFormat();
    $format_data->setAlign('center');
    
// colors are calculated by subtractring 7 from the color table
    
    $i = 0;
    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        $sheet->write(0,$i,$field->name, $format_header_row);
        $i++;
    }
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
        $message = $num_rows . " rows returned!";
        $sheet->write(1,0,$message);
    }
    else
    {
        for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                $sheet->write($j+1,$i,$resultrow[$field->name],$format_data);
                $i++;
            }
            echo "</tr>\n";
        }
    }
    $workbook->close();
}

function XLSWrite($value)
{
    $xls =& new Spreadsheet_Excel_Writer();
    $xls->send("test.xls");
    $sheet =& $xls->addWorksheet('Test XLS');
    $sheet->write(0,0,1);
    $sheet->write(0,1,"Test in XAMPP");
    $format =& $xls->addFormat();
    $format->setBold();
    $format->setColor("blue");
    $sheet->write(1,0,2);
    $sheet->write(1,1,$value,$format);
    $xls->close();
}


// $webalizer="webalizer.bat";
// shell_exec($webalizer);

function send_file($file)
{
    $handle = fopen($file, 'rb');
    header("Content-Type: text/html");
    header("Content-Length: " . filesize($name));
    fpassthru($handle);
}
?>