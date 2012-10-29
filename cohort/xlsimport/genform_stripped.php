<?php 
require_once('./Spreadsheet/excel_reader2.php');

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; iso-8859-1">
<title>EuroCoord WP4: Data Inventory Survey</title>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script> -->
<script type="text/javascript" src="../include/js/jquery.js"></script>
<script type="text/javascript" src="../include/js/jquery-ui-1.8.9.custom.min.js"></script>
<link type="text/css" rel="stylesheet" href="../css/redmond/jquery-ui-1.8.9.redmond.css">
<script type="text/javascript" src="include/jquery.multiselect.js"></script>
<link type="text/css" rel="stylesheet" href="include/jquery.multiselect.css">
<style>
td {
	vertical-align: top
}
</style>
</head>

<body>

<?php 
$excel = new Spreadsheet_Excel_Reader("tables.xls"); //, 'WINDOWS-1253');
$x=1;
$previous_group = "";
$previous_expand = "";
$expand_with_value = "";
$cellspacing = 5;

while ($x <= $excel->sheets[0]['numRows']) {
	$header = trim($excel->val($x, 1));
	$numbering = trim($excel->val($x, 2));
	$question = trim($excel->val($x, 3));
	$datatype = trim($excel->val($x, 4));
	$group_with = trim($excel->val($x, 5));
	$expand_with_value = trim($excel->val($x, 6));
	$url = trim($excel->val($x, 7));
	
	if ($question == "" || $question == "Question") {
		$x++; continue;
	}
	
	if ($expand_with_value == "") {
		$cellspacing = 5;
	} else if ($previous_group != $group_with) {
		$cellspacing += 5;
	}
	
	if ($expand_with_value == "") {
		echo "</table>\n\n";
		echo "<table id='q_$numbering' cellspacing='$cellspacing'>\n";	
	} else if ($previous_group != $group_with || $previous_expand != $expand_with_value) {
		echo "</table>\n\n";
		echo "<table id='q_".$group_with."_sub_$expand_with_value' cellspacing='$cellspacing'  style='display: none'>\n";
	}
	echo "<tr><td>\n";
	echo "<$header>$question</$header>";
	echo "</td><td>\n";
	echo "<select id='q_$numbering";
//	if ($group_with != "") {
//		echo "_sub_$group_with";
//	}
	echo "' onchange='toggle(this, this.value);'>";
	if ($datatype == "YES_NO") {
?>

<option value="-1">- Select one -</option>
<option value="1">YES</option>
<option value="0">NO</option>
</select>
</td><td></td></tr>

<?php 		
	} elseif ($datatype == "DEFAULT") {
?>

<option value="-1">- Select one - </option>
<option value="1">YES</option>
<option value="0">NO</option>
<option value="99">OTHER (please specify)</option>
</select>
</td>
<td><input id="text_<?php echo $numbering;?>" type="text" size="50" /></td>
</tr>
<?php 
	}

	$previous_group = $group_with;
	$previous_expand = $expand_with_value;
	$x++;
}
?>

<script type="text/javascript">
function toggle(el, val) {
	var id = $(el).attr("id");
	var textid = $(el).attr("id").replace("q_", "text_").replace(".", "\\\\.");
//	alert(val);
	$("[id ^= '" + id + "_sub_']").hide();
	$("[id ^= '" + id + ".']").hide();
	$("[id = '" + id + ".1']").show();
	$("[id = '" + id + ".2']").show();
	$("[id = '" + id + ".3']").show();
	$("[id = '" + id + ".4']").show();
	$("[id = '" + id + ".5']").show();
	$("[id = '" + id + ".6']").show();
	$("[id = '" + id + ".7']").show();
	$("[id = '" + id + ".8']").show();
	$("[id = '" + id + ".9']").show();
	$("[id ^= '" + id + "_sub_" + val + "']").show();
//	alert(val);
//	alert(textid);

$("#" + textid).toggle();
//
////if ($("#" + textid).length > 0) {
////	alert($("#" + textid).attr("id"));
//	if ($(el).val() != "99") {
////		alert("other");
//		document.getElementById(textid).style.display = "none";
//	} else {
//		document.getElementById(textid).style.display = "";
////		alert("99");
//	}
////}
}

$(document).ready(function(){

	$("[id ^= 'text_']").hide();	
	
//$("select").multiselect({
//	   multiple: false,
//	   header: "- Select an Option -",
//	   noneSelectedText: "- Select an Option -",
//	   selectedList: 1
//});

});
</script>
</body>
</html>