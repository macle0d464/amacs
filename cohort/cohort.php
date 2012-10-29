<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-7"/>
<title>Cohort PHP Test Page</title>
</head>
<body>
<font name="Courier New Greek" size=3>

<?php
$dbcohort = @mysql_connect("localhost", "root", "97103");
if (!$dbcohort)
 {
    echo( "<P>Unable to connect to the database server at this time.</P>" );
    exit();
 }
 mysql_select_db("cohort", $dbcohort);
if (! @mysql_select_db("cohort") )
 {
    echo( "<P>Unable to locate the COHORT database at this time.</P>" );
    exit();
 }
echo("Connection Success!");
$sql = "SELECT * FROM demographic_data";
$result = mysql_query($sql);
if ( $result )
 {
    echo("<P>Query Successfull!</P>");
 }
else
 {
    echo("<P>Error during SQL Query: " . mysql_error() . "</P>");
 }
echo "<table>\n";

/*
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
   echo "\t<tr>\n";
   foreach ($line as $col_value) {
       echo "\t\t<td>$col_value</td>\n";
   }
   echo "\t</tr>\n";
}
echo "</table>\n";
*/

while ($row = mysql_fetch_object($result))
 {
   echo "<p>Κωδικός Ασθενή: " . $row->PatientCode . "</p>";
   echo "<p>Κωδικός ΜΕΛ: " . $row->MELCode . "</p>";
 }


if ( isset($name) )
 {
    echo $name;
 }
else
 {
    echo "No Name";
 }

mysql_free_result($result);
mysql_close($dbcohort);
?>

<!--
INSERT INTO `demographic_data` ( `PatientCode` , `MELCode` , `FullName` , `Name2` , `Surname2` , `Completed` , `LastVisit` ,
`Race` , `Gender` , `Dateofbirth` , `RecentKg` , `RcentKgDate` , `ClinicDuringRecord` , `PreviousClinic` ,
`PossibleSourceInfection` , `PossibleSourceExtraData` , `KnownDateOrometatropi` , `LastNegativeSample` , `FirstPositiveSample` ,
`FirstEntryAtClinic` )
VALUES (
'0', '0', 'Test Name', '', '', '0000-00-00', '0000-00-00', '0', '0', '0000-00-00', '0', '0000-00-00', '0', '0', '0', 'N', 'N',
'0000-00-00', '0000-00-00', '0000-00-00'
);
-->

</font>
τραλά
</body>
</html>
