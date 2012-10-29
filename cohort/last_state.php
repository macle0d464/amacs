<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$state_query = "SELECT * FROM last_state WHERE PatientCode=".$_GET['code'];
	$result = execute_query($state_query);
	$has_entry = mysql_num_rows($result);
	$resultrow = mysql_fetch_assoc($result);
	

	$deaths_result = execute_query("SELECT * FROM deaths_list");
	$deaths_base = "";
	$deaths_extra = array();
	$deaths_extra_icd10 = array();
	$deaths_extra['01'] = "";
	$deaths_extra['02'] = "";
	$deaths_extra['03'] = "";
	$deaths_extra['04'] = "";
	$deaths_extra['05'] = "";
	$deaths_extra['06'] = "";
	$deaths_extra['07'] = "";
	$deaths_extra['08'] = "";
	$deaths_extra['09'] = "";
	for ($k=1; $k<100; $k++)
	{
			$deaths_extra[''.$k] = "";	
	}
	for ($i=0; $i<mysql_num_rows($deaths_result); $i++)
	{
		$row = mysql_fetch_assoc($deaths_result);
		if ($row['CodeType'] == '1')
		{
			$deaths_base .= "<option value='".$row['Code']."'>".$row['Description']."</option>\n";	
		}
		if ($row['CodeType'] == '2')
		{
			$id = substr($row['Code'], 0, 2);
			$deaths_extra[$id] .= "<option value='".$row['Code']."'>".$row['Description']."</option>";	
		}
		if ($row['ICD10_extra'] != "")
		{
//			$deaths_extra_icd10[$row['Code']] = "window.open('./icd-10/showpage.php?page=" . $row['ICD10_extra'] . "&field=";//othercause1
			$deaths_extra_icd10[$row['Code']] = $row['ICD10_extra'] ;//othercause1
		}
	}
//echo "<pre>";
//print_r($deaths_base);
//print_r($deaths_extra);
//die;
?>
<HTML>
    <HEAD>
        <TITLE>���������� ���������� ���������� ������</TITLE>
        <META http-equiv=Content-Type content="text/html; charset=windows-1253">
        <link href="./include/cohort.css" rel="stylesheet" type="text/css">
    </HEAD>
    <? PrintMenu(); ?>
    <P>
        &nbsp;
    </P>
    <P>
        &nbsp;
    </P>
    <?
if (!isset($_GET['code']) || ($_GET['code'] == ""))
{
	Print_PatientCode_form("last_state.php");
	die();
}
else
{
	check_patient($_GET['code']);
}
    ?>
    <DIV style="position: absolute; left:30px;">
        <FORM id="last_state_form" name="last_state_form" action="last_state_insert.php" method="GET" onsubmit="return check_data();">
            <? show_patient_data($_GET['code']); ?>
            <table>
                <tr>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        ��������� ������: &nbsp;
                        <select name="LastState" onchange="show_extra(this.value);">
                            <option value="" selected>-   �������� -  </option>
                            <option value="1">�� ���</option>
                            <option value="2">��������</option>
                            <option value="3">Lost to Follow Up</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
            </table>
			<script type="text/javascript">
				function toggle_death_date(value)
				{
					if (value == -1)
					{
						document.getElementById("deathdateknown").style.display = "none";
						document.getElementById("deathdateunknown").style.display = "none";						
					}
					if (value == 0)
					{
						document.getElementById("deathdateknown").style.display = "none";
						document.getElementById("deathdateunknown").style.display = "";						
					}
					if (value == 1)
					{
						document.getElementById("deathdateknown").style.display = "";
						document.getElementById("deathdateunknown").style.display = "none";						
					}
				}
			</script>
            <div id="death_extra" style="display: none">
                <table>
                	<tr>
                		<td colspan="2">�����  ������ � ���������� ������� ��� ������:
						<select name="deathdatetype" onchange="toggle_death_date(this.value)">
							<option value="">- �������� - </option>
							<option value="1"> NAI </option>
							<option value="0"> OXI </option>
						</select></td>
                	</tr>
                    <tr id="deathdateknown" style="display: none">
                        <td>
                            ���������� ������� &nbsp;
                        </td>
                        <td>
                            �����:
                            <select name=DeathDate_day>
                                <option value="" selected></option>
                                <? print_options(31); ?>
                            </select>&nbsp; 
                            �����: 
                            <select name=DeathDate_month>
                                <option value="" selected></option>
                                <? print_options(12); ?>
                            </select>&nbsp; 
                            ����: 
                            <select name=DeathDate_year>
                                <option value="" selected></option>
                                <? print_years(); ?>
                            </select>
                        </td>
					</tr>
                    <tr id="deathdateunknown" style="display: none">
                        <td>
                            ���������� ��� ����� ������<BR>��� � ������� �������� &nbsp;
                        </td>
                        <td>
                            �����:
                            <select name=DateDeathKnown_day>
                                <option value="" selected></option>
                                <? print_options(31); ?>
                            </select>&nbsp; 
                            �����: 
                            <select name=DateDeathKnown_month>
                                <option value="" selected></option>
                                <? print_options(12); ?>
                            </select>&nbsp; 
                            ����: 
                            <select name=DateDeathKnown_year>
                                <option value="" selected></option>
                                <? print_years(); ?>
                            </select>
                        </td>
					</tr>
                        <tr>
                            <td>
                                '����� (Immediate) ����� �������: &nbsp;&nbsp;
                            </td>
                            <td>
                       
                                <select name="Immediate" onchange="show_other(this.value, 'immediate_2', 'immediate_other', 'othercause1');">
                                    <option value="">- �������� -</option>
								<? echo $deaths_base; ?>									
                                </select>
                                <BR>
<span id="immediate_2"></span>
<span id="immediate_other" style="display: none">'���� �����:<input id=othercause1 name=othercause1 onclick="window.open('./icd-10/showpage.php?page=death_other.htm&field=othercause1', '�����', 'width=550,height=600,status=yes,scrollbars=yes,toolbar=yes');" onfocus="this.blur();">
<? echo "<img src=\"./images/b_help.png\" style=\"cursor: pointer\" onclick=\"window.open('./icd-10/findcode.php?code='+document.all.othercause1.value, '������ ������� ICD-10', 'width=450,height=300,status=yes');\"/>"; ?>
</span>
                            </td>
                        </tr>
                        <tr>
                        <td>
                            &nbsp;
                        </td>
                        </td>
                        <td>
                    </tr>
                    <tr>
                        <td>
                            Contributing ����� �������:
                        </td>
                        <td>
                            <select name="Contributing1" onchange="show_other(this.value, 'contributing1_2', 'contributing1_other', 'othercause2');">
                                <option value="">- �������� -</option>
								<? echo $deaths_base; ?>									
                            </select>
                            <BR>
<span id="contributing1_2"></span>
<span id="contributing1_other" style="display: none">'���� �����:<input id=othercause2 name=othercause2 onclick="window.open('./icd-10/showpage.php?page=death_other.htm&field=othercause2', '�����', 'width=550,height=600,status=yes,scrollbars=yes,toolbar=yes');" onfocus="this.blur();">
<? echo "<img src=\"./images/b_help.png\" style=\"cursor: pointer\" onclick=\"window.open('./icd-10/findcode.php?code='+document.all.othercause2.value, '������ ������� ICD-10', 'width=450,height=300,status=yes');\"/>"; ?>
</span>
                        </td>
                    </tr>
                    <tr>
                    <td>
                        &nbsp;
                    </td>
                    </td>
                    <td>
                </tr>
                <tr>
                    <td>
                        Contributing ����� �������:
                    </td>
                    <td>
                        <select name="Contributing2" onchange="show_other(this.value, 'contributing2_2', 'contributing2_other', 'othercause3');">
                            <option value="">- �������� -</option>
							<? echo $deaths_base; ?>									
                        </select>
                        <BR>
<span id="contributing2_2"></span>
<span id="contributing2_other" style="display: none">'���� �����:<input id=othercause3 name=othercause3 onclick="window.open('./icd-10/showpage.php?page=death_other.htm&field=othercause3', '�����', 'width=550,height=600,status=yes,scrollbars=yes,toolbar=yes');" onfocus="this.blur();">
<? echo "<img src=\"./images/b_help.png\" style=\"cursor: pointer\" onclick=\"window.open('./icd-10/findcode.php?code='+document.all.othercause3.value, '������ ������� ICD-10', 'width=450,height=300,status=yes');\"/>"; ?>
</span>
                    </td>
                </tr>
                <tr>
                <td>
                    &nbsp;
                </td>
                </td>
                <td>
            </tr>
            <tr>
                <td>
                    Contributing ����� �������:
                </td>
                <td>
                    <select name="Contributing3" onchange="show_other(this.value, 'contributing3_2', 'contributing3_other', 'othercause4');">
                        <option value="">- �������� -</option>
						<? echo $deaths_base; ?>									
                    </select>
                    <BR>
<span id="contributing3_2"></span>
<span id="contributing3_other" style="display: none">'���� �����:<input id=othercause4 name=othercause4 onclick="window.open('./icd-10/showpage.php?page=death_other.htm&field=othercause4', '�����', 'width=550,height=600,status=yes,scrollbars=yes,toolbar=yes');" onfocus="this.blur();">
<? echo "<img src=\"./images/b_help.png\" style=\"cursor: pointer\" onclick=\"window.open('./icd-10/findcode.php?code='+document.all.othercause4.value, '������ ������� ICD-10', 'width=450,height=300,status=yes');\"/>"; ?>
                </td>
            </tr>
            <tr>
            <td>
                &nbsp;
            </td>
            </td>
            <td>
        </tr>
        <tr>
            <td>
                Contributing ����� �������:
            </td>
            <td>
                <select name="Contributing4" onchange="show_other(this.value, 'contributing4_2', 'contributing4_other', 'othercause5');">
                    <option value="">- �������� -</option>
					<? echo $deaths_base; ?>									
                </select>
                <BR>
<span id="contributing4_2"></span>
<span id="contributing4_other" style="display: none">'���� �����:<input id=othercause5 name=othercause5 onclick="window.open('./icd-10/showpage.php?page=death_other.htm&field=othercause5', '�����', 'width=550,height=600,status=yes,scrollbars=yes,toolbar=yes');" onfocus="this.blur();">
                <?
echo "<img src=\"./images/b_help.png\" style=\"cursor: pointer\" onclick=\"window.open('./icd-10/findcode.php?code='+document.all.othercause5.value, '������ ������� ICD-10', 'width=450,height=300,status=yes');\"/>";
                ?>
            </td>
        </tr>
        <tr>
        <td>
            &nbsp;
        </td>
        </td>
        <td>
    </tr>
    <tr>
        <td>
            Underlying ����� �������:
        </td>
        <td>
            <select name="Underlying" onchange="show_other(this.value, 'Underlying_2', 'underlying_other', 'othercause6');">
                <option value="">- �������� -</option>
				<? echo $deaths_base; ?>									
            </select>
            <BR>
<span id="Underlying_2"></span>
<span id="underlying_other" style="display: none">'���� �����:<input id=othercause6 name=othercause6 onclick="window.open('./icd-10/showpage.php?page=death_other.htm&field=othercause6', '�����', 'width=550,height=600,status=yes,scrollbars=yes,toolbar=yes');" onfocus="this.blur();">
<? echo "<img src=\"./images/b_help.png\" style=\"cursor: pointer\" onclick=\"window.open('./icd-10/findcode.php?code='+document.all.othercause6.value, '������ ������� ICD-10', 'width=450,height=300,status=yes');\"/>"; ?>
        </td>
    </tr>
    <tr>
        <td>
            ����������:
        </td>
        <td>
            <textarea name="Notes_death" id="Notes_death" style="width: 480px; height: 83px">
            </textarea>
        </td>
    </tr>
    <tr>
        <td>
            &nbsp;
        </td>
    </tr>
    </table>
    <p>
        '����:
    </p>
    <UL>
        <LI>
        Immediate cause of death: The disease(s) or injury directly leading to death.
        </li>
        <li>
            Contributing cause of death: The disease(s) or injury, which contributed to a fatal outcome.
        </li>
        <li>
            Underlying cause of death: The disease or injury, which initiated the train of morbid events leading directly 
            <br>
            or indirectly to death, or the circumstance of the accident or violence, which produced the fatal injury.
        </li>
    </UL>
</div>
<div id=enzoi style="display: none">
    <table>
        <tr>
            <td>
                ���������� ��������� &nbsp;&nbsp;
            </td>
            <td>
                �����:
                <select name=DateOfVisit_day>
                    <option value="" selected></option>
                    <? print_options(31); ?>
                </select>&nbsp; 
                �����: 
                <select name=DateOfVisit_month>
                    <option value="" selected></option>
                    <? print_options(12); ?>
                </select>&nbsp; 
                ����: 
                <select name=DateOfVisit_year>
                    <option value="" selected></option>
                    <? print_years(); ?>
                </select>
            </td>
        </tr>
        <tr>
            <TD>
                �������: 
            </TD>
            <TD>
                <SELECT name=Clinic>
                    <OPTION value="" selected>-   �������� -  </OPTION>
                    <?php
	$clinics_query = "SELECT * FROM clinics";
	$results = execute_query($clinics_query);		
	$num_clinics = mysql_num_rows($results);
	for ($i = 0; $i < $num_clinics; $i++)
	{
		$row = mysql_fetch_assoc($results);
		$value = $row['ClinicName'];
		$j=$i+1;
		echo "<OPTION value='$j'> $value </OPTION>";
	}
	mysql_free_result($results);
                    ?>
                </SELECT>
            </TD>
        </tr>
    </table>
    <p>
    </p>
</div>
<div id=lost style="display: none">
    <table>
        <tr>
            <td>
                �����:
            </td>
            <td>
                <select name=Lost2FollowUp onchange="show_date(this.value)">
                    <option value="">- �������� - </option>
                    <option value="1">� ������� ��� ���� ���������� ��� ��������� �����</option>
                    <option value="2">� ������� ����������</option>
                    <option value="3">� ������� ��������������� �� ���� ������</option>
                    <option value="4">������� ��������</option>
                    <option value="5">�������� ����������</option>
                    <option value="6">'A��� ����� (������������ ���� ����������)</option>
                </select>
                <td>
                </tr>
                <tr id=last_date>
                    <td>
                        ��������� ������ ����������&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <BR>
                        ��� � ������� ����� �� ���: &nbsp;&nbsp;&nbsp;
                    </td>
                    <td>
                        �����:
                        <select name=LastKnownToBeAlive_day>
                            <option value="" selected></option>
                            <? print_options(31); ?>
                        </select>&nbsp; 
                        �����: 
                        <select name=LastKnownToBeAlive_month>
                            <option value="" selected></option>
                            <? print_options(12); ?>
                        </select>&nbsp; 
                        ����: 
                        <select name=LastKnownToBeAlive_year>
                            <option value="" selected></option>
                            <? print_years(); ?>
                        </select>
                    </td>
                </tr>
                <tr id=withdraw_date style="display: none">
                    <td>
                        ���������� ��������� ����������: &nbsp;&nbsp;&nbsp;
                    </td>
                    <td>
                        �����:
                        <select name=WithdrawalDate_day>
                            <option value="" selected></option>
                            <? print_options(31); ?>
                        </select>&nbsp; 
                        �����: 
                        <select name=WithdrawalDate_month>
                            <option value="" selected></option>
                            <? print_options(12); ?>
                        </select>&nbsp; 
                        ����: 
                        <select name=WithdrawalDate_year>
                            <option value="" selected></option>
                            <? print_years(); ?>
                        </select>
                    </td>
                </tr>
                <tr id=newcli style="display: none">
                    <td>
                        ��� ������� ��������������: &nbsp;&nbsp;&nbsp;
                    </td>
                    <td>
                        <select name=NewClinic>
                            <OPTION value="" selected>-   �������� -  </OPTION>
                            <?php
	$results = execute_query($clinics_query);		
	$num_clinics = mysql_num_rows($results);
	for ($i = 0; $i < $num_clinics; $i++)
	{
		$row = mysql_fetch_assoc($results);
		$value = $row['ClinicName'];
		$j=$i+1;
		echo "<OPTION value='$j'> $value </OPTION>";
	}
	mysql_free_result($results);
                            ?>
                        </select>
                    </td>
                </tr>
                <td>
                    ����������:
                </td>
                <td>
                    <textarea name=Notes_lost style="width: 347px; height: 100px">
                    </textarea>
                </td>
            </table>
<!--            </div> -->
            <p>
            </p>
            <?
	echo "<input type=hidden name=has_entry value=$has_entry>";
	echo "<input type=hidden name=last_state value=".$resultrow['LastState'].">";
            ?>

        </div>
		<input type="submit" value="���������� ���������">
        </FORM>
		<script>
            function show_extra(id){
                if (id == 1) {
                    document.all['enzoi'].style.display = "";
                    document.all['death_extra'].style.display = "none";
                    document.all['lost'].style.display = "none";
                }
                else 
                    if (id == 2) {
                        document.all['enzoi'].style.display = "none";
                        document.all['death_extra'].style.display = "";
                        document.all['lost'].style.display = "none";
                    }
                    else 
                        if (id == 3) {
                            document.all['enzoi'].style.display = "none";
                            document.all['death_extra'].style.display = "none";
                            document.all['lost'].style.display = "";
                        }
            }
            
            function show_date(id){
                if (id == 5) {
                    document.all['withdraw_date'].style.display = "";
                    document.all['newcli'].style.display = "none";
                }
                else 
                    if (id == 3) {
                        document.all['withdraw_date'].style.display = "none";
                        document.all['newcli'].style.display = "";
                    }
                    else {
                        document.all['withdraw_date'].style.display = "none";
                        document.all['newcli'].style.display = "none";
                    }
            }
            
            function doc(el){
                return document.all[el];
            }
            
            function check_data(){
            
                if (doc("LastState").value == 1) {
                    if (doc("Clinic").value == "") {
                        alert("������ �� ��������� ��� �������!");
                        return false;
                    }
                    if (doc("DateOfVisit_year").value == "") {
                        alert("������ �� ��������� �� ����� ��� ��������� ���� �������!");
                        return false;
                    }
                    if (doc("DateOfVisit_month").value == "") {
                        alert("������ �� ��������� �� ���� ��� ��������� ���� �������!");
                        return false;
                    }
                    if (doc("DateOfVisit_day").value == "") {
                        alert("������ �� ��������� ��� ����� ��� ��������� ���� �������!");
                        return false;
                    }
                }
                if (doc("LastState").value == 2) {
					if (doc("deathdatetype").value == "") {
                        alert("������ �� ��������� �� ����� ������ � ���������� ������� ��� ������!");
                        return false;						
					}
					if (doc("deathdatetype").value == "1") {
						if (doc("DeathDate_year").value == "") {
							alert("������ �� ��������� �� ����� ���� ���������� �������!");
							return false;
						}
						if (doc("DeathDate_month").value == "") {
							alert("������ �� ��������� �� ���� ���� ���������� �������!");
							return false;
						}
						if (doc("DeathDate_day").value == "") {
							alert("������ �� ��������� ��� ����� ���� ���������� �������!");
							return false;
						}	
					}
					if (doc("deathdatetype").value == "0") {
						if (doc("DateDeathKnown_year").value == "") {
							alert("������ �� ��������� �� ����� ���� ���������� ��� ����� ������ ��� � ������� ��������!");
							return false;
						}
						if (doc("DateDeathKnown_month").value == "") {
							alert("������ �� ��������� �� ���� ���� ���������� ��� ����� ������ ��� � ������� ��������!");
							return false;
						}
						if (doc("DateDeathKnown_day").value == "") {
							alert("������ �� ��������� ��� ����� ���� ���������� ��� ����� ������ ��� � ������� ��������!");
							return false;
						}	
					}		
                    if (doc("Immediate").value == "") {
                        alert("������ �� ��������� ��� ������ ���� �������!");
                        return false;
                    }
                    if (doc("Immediate").value == "90") {
                        if (doc("othercause1").value == "") {
                            alert("������ �� ������������� ���� ����� � ���� ���� �������!");
                            return false;
                        }
                    }
                    if (doc("Immediate").value == "") {
                        alert("������ �� ��������� ��� ������ ���� �������!");
                        return false;
                    }
                    if (doc("Immediate").value == "90") {
                        if (doc("othercause1").value == "") {
                            alert("������ �� ������������� ���� ����� � ���� ���� �������!");
                            return false;
                        }
                    }
                    if (doc("Underlying").value == "") {
                        alert("������ �� ��������� ��� underlying ���� �������!");
                        return false;
                    }
                    if (doc("Underlying").value == "90") {
                        if (doc("othercause6").value == "") {
                            alert("������ �� ������������� ���� ����� � ���� ���� �������!");
                            return false;
                        }
                    }
                    if (doc("Contributing1").value == "90") {
                        if (doc("othercause2").value == "") {
                            alert("������ �� ������������� ���� ����� � ���� ���� �������!");
                            return false;
                        }
                    }
                    if (doc("Contributing2").value == "90") {
                        if (doc("othercause3").value == "") {
                            alert("������ �� ������������� ���� ����� � ���� ���� �������!");
                            return false;
                        }
                    }
                    if (doc("Contributing3").value == "90") {
                        if (doc("othercause4").value == "") {
                            alert("������ �� ������������� ���� ����� � ���� ���� �������!");
                            return false;
                        }
                    }
                    if (doc("Contributing4").value == "90") {
                        if (doc("othercause5").value == "") {
                            alert("������ �� ������������� ���� ����� � ���� ���� �������!");
                            return false;
                        }
                    }
                }
                if (doc("LastState").value == 3) {
                    if (doc("Lost2FollowUp").value == "") {
                        alert("������ �� ��������� ��� �����!");
                        return false;
                    }
                    if (doc("Lost2FollowUp").value == "1") {
                        if (doc("LastKnownToBeAlive_year").value == "") {
                            alert("������ �� ��������� �� ����� ���� ����������!");
                            return false;
                        }
                        if (doc("LastKnownToBeAlive_month").value == "") {
                            alert("������ �� ��������� �� ���� ���� ����������!");
                            return false;
                        }
                        if (doc("LastKnownToBeAlive_day").value == "") {
                            alert("������ �� ��������� ��� ����� ���� ����������!");
                            return false;
                        }
                    }
                    if (doc("Lost2FollowUp").value == "3") {
                        if (doc("NewClinic").value == "") {
                            alert("������ �� ��������� ��� ��� ������� ��������������!");
                            return false;
                        }
                    }
                }
                //	return true;
            }
        </script>
<script type="text/javascript">
var str_HTMLoptions = new Array();
var str_ICD10_extra = new Array();

<?
echo "str_HTMLoptions['01'] = \"".$deaths_extra['01']."\";\n";
echo "str_HTMLoptions['02'] = \"".$deaths_extra['02']."\";\n";
echo "str_HTMLoptions['03'] = \"".$deaths_extra['03']."\";\n";
echo "str_HTMLoptions['04'] = \"".$deaths_extra['04']."\";\n";
echo "str_HTMLoptions['05'] = \"".$deaths_extra['05']."\";\n";
echo "str_HTMLoptions['06'] = \"".$deaths_extra['06']."\";\n";
echo "str_HTMLoptions['07'] = \"".$deaths_extra['07']."\";\n";
echo "str_HTMLoptions['08'] = \"".$deaths_extra['08']."\";\n";
echo "str_HTMLoptions['09'] = \"".$deaths_extra['09']."\";\n";
			
for ($i=10; $i<101; $i++)
{
	echo "str_HTMLoptions['".$i."'] = \"".$deaths_extra[$i]."\";\n";
}

echo "str_ICD10_extra['04.10'] = \"".$deaths_extra_icd10['04.10']."\";\n";
for ($i=10; $i<101; $i++)
{
	if ($deaths_extra_icd10[$i] != "")
	{
		echo "str_ICD10_extra['".$i."'] = \"".$deaths_extra_icd10[$i]."\";\n"; // + othercause + \"', '�����', 'width=550,height=600,status=yes,scrollbars=yes,toolbar=yes');\";\n";
	}
}
?>

function show_other(value, span_id1, span_id2, othercause)
{
	if (value == "")
	{
		document.getElementById(span_id1).style.display = "none";
		document.getElementById(span_id2).style.display = "none";
	}
	if (value == 90)
	{
		document.getElementById(span_id1).style.display = "none";
		document.getElementById(span_id2).style.display = "";
	}
	else
	{
		if (str_HTMLoptions[value] != "")
		{
			document.getElementById(span_id1).innerHTML = "<select name='" + span_id1 + "' onchange=\"show_extra_icd10(this.value, '" + span_id2 + "', '" + othercause + "');\">" + str_HTMLoptions[value] + "</select>";	
		}
		else if (str_ICD10_extra[value] != "")
		{
			document.getElementById(span_id1).innerHTML = "";
			show_extra_icd10(value, span_id2, othercause);
		}
		else
		{
			document.getElementById(span_id1).innerHTML = "";
			document.getElementById(span_id2).innerHTML = "";			
		}		
		document.getElementById(span_id1).style.display = "";
	}
}

function show_extra_icd10(code, span_id2, othercause)
{

	if (str_ICD10_extra[code] != null)
	{
		document.getElementById(span_id2).style.display = "";
		document.getElementById(othercause).onclick = function(){
			window.open("./icd-10/showpage.php?page=" + str_ICD10_extra[code] + "&field=" + othercause, "�����", "width=550,height=600,status=yes,scrollbars=yes,toolbar=yes")
		};
	}
	else
	{
		document.getElementById(span_id2).style.display = "none";
		document.getElementById(othercause).onclick = null;
	}

}
//this.value, 'immediate1_2', 'immediate_other')	
</script>

            <? $last_state = $resultrow['LastState'];
$death_date = $resultrow['DeathDate'];
if ($last_state == "1")
	{
//		echo "<hr><h3>� ������� ����� �� ���</h3>";
	}
if ($last_state == "3")
	{
		echo "<script>";
		echo "document.all.LastState.value='3';\n";
		echo "document.all.Lost2FollowUp.value='".$resultrow['Lost2FollowUp']."';\n";
		echo "document.all['LastKnownToBeAlive_year'].value = '".retyear($resultrow['LastKnownToBeAlive'])."'; ";
		echo "document.all['LastKnownToBeAlive_month'].value = '".retmonth($resultrow['LastKnownToBeAlive'])."'; ";
		echo "document.all['LastKnownToBeAlive_day'].value = '".retday($resultrow['LastKnownToBeAlive'])."'; ";
//		echo "document.all['last_date'].style.display = '';";
		if ($resultrow['Lost2FollowUp'] == "3")
		{
			echo "document.all['NewClinic'].value = '".$resultrow['NewClinic']."'; ";
			echo "document.all['newcli'].style.display = '';";
		}		
		if ($resultrow['Lost2FollowUp'] == "5")
		{
			echo "document.all['WithdrawalDate_year'].value = '".retyear($resultrow['WithdrawalDate'])."'; ";
			echo "document.all['WithdrawalDate_month'].value = '".retmonth($resultrow['WithdrawalDate'])."'; ";
			echo "document.all['WithdrawalDate_day'].value = '".retday($resultrow['WithdrawalDate'])."'; ";
			echo "document.all['withdraw_date'].style.display = '';";
		}		
		echo "document.all.Notes_lost.value='".$resultrow['Notes']."';\n";
		echo "document.all['lost'].style.display = '';";
		echo "</script>";  
	} 
if ($last_state == "2")
	{
		echo "<script>";
		echo "document.all.LastState.value='2';\n";
		if ($resultrow['DeathDate'] != "") {
			echo "document.all['DeathDate_year'].value = '".retyear($resultrow['DeathDate'])."'; ";
			echo "document.all['DeathDate_month'].value = '".retmonth($resultrow['DeathDate'])."'; ";
			echo "document.all['DeathDate_day'].value = '".retday($resultrow['DeathDate'])."'; ";	
			echo "toggle_death_date('1');\n";
			echo "document.all['deathdatetype'].value = '1';\n";
		}
		if ($resultrow['DateDeathKnown'] != "") {
			echo "document.all['DateDeathKnown_year'].value = '".retyear($resultrow['DateDeathKnown'])."'; ";
			echo "document.all['DateDeathKnown_month'].value = '".retmonth($resultrow['DateDeathKnown'])."'; ";
			echo "document.all['DateDeathKnown_day'].value = '".retday($resultrow['DateDeathKnown'])."'; ";	
			echo "toggle_death_date('0');\n";
			echo "document.all['deathdatetype'].value = '0';\n";
		}
		echo "document.all['Notes_death'].value='".$resultrow['Notes']."';\n";
		echo "document.all['death_extra'].style.display = '';\n";

		list($info_combined, $trash, $icd10) = split("[ ]", $resultrow['Immediate']);
		list($level1, $level2) = split("[.]", $info_combined);
		echo "document.all.Immediate.value='".$level1."';\n";
        if ($deaths_extra_icd10[$info_combined] != '') {
            echo "show_other('".$level1."', 'immediate_2', 'immediate_other', 'othercause1');\n";
            echo "show_extra_icd10('".$info_combined."', 'immediate_other', 'othercause1');\n";
            echo "document.all.othercause1.value='".$icd10."';\n";            
        }
        if ($info_combined != $level1) {			
			echo "show_other('".$level1."', 'immediate_2', 'immediate_other', 'othercause1');\n";
			echo "show_extra_icd10('".$info_combined."', 'immediate_other', 'othercause1');\n";
			echo "document.getElementsByName('immediate_2')[0].value='".$info_combined."';\n";
			echo "document.all.othercause1.value='".$icd10."';\n";
		}
		if ($level1 == "90") {
			echo "document.getElementById('immediate_other').style.display = '';\n";	
			echo "document.all.othercause1.value='".$icd10."';\n";			
		}

		list($info_combined, $trash, $icd10) = split("[ ]", $resultrow['Contributing1']);
		list($level1, $level2) = split("[.]", $info_combined);
		echo "document.all.Contributing1.value='".$level1."';\n";
        if ($deaths_extra_icd10[$info_combined] != '') {
            echo "show_other('".$level1."', 'contributing1_2', 'contributing1_other', 'othercause2');\n";
            echo "show_extra_icd10('".$info_combined."', 'contributing1_other', 'othercause2');\n";
            echo "document.all.othercause2.value='".$icd10."';\n";
        }        
		if ($info_combined != $level1) {
			echo "show_other('".$level1."', 'contributing1_2', 'contributing1_other', 'othercause2');\n";
			echo "show_extra_icd10('".$info_combined."', 'contributing1_other', 'othercause2');\n";
			echo "document.getElementsByName('contributing1_2')[0].value='".$info_combined."';\n";
			echo "document.all.othercause2.value='".$icd10."';\n";
		}
		if ($level1 == "90") {
			echo "document.getElementById('contributing1_other').style.display = '';\n";	
			echo "document.all.othercause2.value='".$icd10."';\n";			
		}

		list($info_combined, $trash, $icd10) = split("[ ]", $resultrow['Contributing2']);
		list($level1, $level2) = split("[.]", $info_combined);
		echo "document.all.Contributing2.value='".$level1."';\n";
        if ($deaths_extra_icd10[$info_combined] != '') {
            echo "show_other('".$level1."', 'contributing2_2', 'contributing2_other', 'othercause3');\n";
            echo "show_extra_icd10('".$info_combined."', 'contributing2_other', 'othercause3');\n";
            echo "document.all.othercause3.value='".$icd10."';\n";                  
        }        
		if ($info_combined != $level1) {
			echo "show_other('".$level1."', 'contributing2_2', 'contributing2_other', 'othercause3');\n";
			echo "show_extra_icd10('".$info_combined."', 'contributing2_other', 'othercause3');\n";
			echo "document.getElementsByName('contributing2_2')[0].value='".$info_combined."';\n";
			echo "document.all.othercause3.value='".$icd10."';\n";		
		}
		if ($level1 == "90") {
			echo "document.getElementById('contributing2_other').style.display = '';\n";	
			echo "document.all.othercause3.value='".$icd10."';\n";			
		}

		list($info_combined, $trash, $icd10) = split("[ ]", $resultrow['Contributing3']);
		list($level1, $level2) = split("[.]", $info_combined);
		echo "document.all.Contributing3.value='".$level1."';\n";
        if ($deaths_extra_icd10[$info_combined] != '') {
            echo "show_other('".$level1."', 'contributing3_2', 'contributing3_other', 'othercause4');\n";
            echo "show_extra_icd10('".$info_combined."', 'contributing3_other', 'othercause4');\n";
            echo "document.all.othercause4.value='".$icd10."';\n";      
        }        
		if ($info_combined != $level1) {
			echo "show_other('".$level1."', 'contributing3_2', 'contributing3_other', 'othercause4');\n";
			echo "show_extra_icd10('".$info_combined."', 'contributing3_other', 'othercause4');\n";
			echo "document.getElementsByName('contributing3_2')[0].value='".$info_combined."';\n";
			echo "document.all.othercause4.value='".$icd10."';\n";		
		}
		if ($level1 == "90") {
			echo "document.getElementById('contributing3_other').style.display = '';\n";	
			echo "document.all.othercause4.value='".$icd10."';\n";			
		}
		
		list($info_combined, $trash, $icd10) = split("[ ]", $resultrow['Contributing4']);
		list($level1, $level2) = split("[.]", $info_combined);
		echo "document.all.Contributing4.value='".$level1."';\n";
        if ($deaths_extra_icd10[$info_combined] != '') {
            echo "show_other('".$level1."', 'contributing4_2', 'contributing4_other', 'othercause5');\n";
            echo "show_extra_icd10('".$info_combined."', 'contributing4_other', 'othercause5');\n";
            echo "document.all.othercause5.value='".$icd10."';\n";      
        }
		if ($info_combined != $level1) {
			echo "show_other('".$level1."', 'contributing4_2', 'contributing4_other', 'othercause5');\n";
			echo "show_extra_icd10('".$info_combined."', 'contributing4_other', 'othercause5');\n";
			echo "document.getElementsByName('contributing4_2')[0].value='".$info_combined."';\n";
			echo "document.all.othercause5.value='".$icd10."';\n";		
		}
		if ($level1 == "90") {
			echo "document.getElementById('contributing4_other').style.display = '';\n";	
			echo "document.all.othercause5.value='".$icd10."';\n";			
		}
		
		list($info_combined, $trash, $icd10) = split("[ ]", $resultrow['Underlying']);
		list($level1, $level2) = split("[.]", $info_combined);
		echo "document.all.Underlying.value='".$level1."';\n";
        if ($deaths_extra_icd10[$info_combined] != '') {
            echo "show_other('".$level1."', 'Underlying_2', 'underlying_other', 'othercause6');\n";
            echo "show_extra_icd10('".$info_combined."', 'underlying_other', 'othercause6');\n";
            echo "document.all.othercause6.value='".$icd10."';\n";
        }
		if ($info_combined != $level1) {
			echo "show_other('".$level1."', 'Underlying_2', 'underlying_other', 'othercause6');\n";
			echo "show_extra_icd10('".$info_combined."', 'underlying_other', 'othercause6');\n";
			echo "document.getElementsByName('Underlying_2')[0].value='".$info_combined."';\n";
			echo "document.all.othercause6.value='".$icd10."';\n";
		}
		if ($level1 == "90") {
			echo "document.getElementById('underlying_other').style.display = '';\n";	
			echo "document.all.othercause6.value='".$icd10."';\n";			
		}
		
		echo "</script>";  
	} 	
            ?>	


    </BODY>
    </HTML>
    <? 	
//mysql_free_result($resultrow);
mysql_close($dbconnection); 
    ?>

<!--                                    <option value="01">01 AIDS (ongoing active disease)</option>
                                    <option value="01.1">01.1 Infection</option>
                                    <option value="01.2">01.2 Malignancy</option>
                                    <option value="02">02 Infection (other than 01.1)</option>
                                    <option value="02.1">02.1 Bacterial</option>
                                    <option value="02.1.1">02.1.1 Bacterial with sepsis</option>
                                    <option value="02.2">02.2 Others</option>
                                    <option value="02.2.1">02.2.1 Other with sepsis</option>
                                    <option value="02.3">02.3 Unknown aetiology</option>
                                    <option value="02.3.1">02.3.1 Unknown with sepsis</option>
                                    <option value="03">03 Chronic viral hepatitis (progression of / complication to)</option>
                                    <option value="03.1">03.1 HCV</option>
                                    <option value="03.1.1">03.1.1 HCV with cirrhosis</option>
                                    <option value="03.1.2">03.1.2 HCV with liver failure</option>
                                    <option value="03.2">03.2 HBV</option>
                                    <option value="03.2.1">03.2.1 HBV with cirrhosis</option>
                                    <option value="03.2.2">03.2.2 HBV with liver failure</option>
                                    <option value="04">04 Malignancy (other than 01.2 and 03, 03.1, 03.2)</option>
                                    <option value="05">05 Diabetes Mellitus (complication to)</option>
                                    <option value="06">06 Pancreatitis</option>
                                    <option value="07">07 Lactic acidosis</option>
                                    <option value="08">08 MI or other ischemic heart disease</option>
                                    <option value="09">09 Stroke</option>
                                    <option value="10">10 Gastro-intestinal haemorrhage (if chosen, specify underlying cause)</option>
                                    <option value="11">11 Primary pulmonary hypertension</option>
                                    <option value="12">12 Lung embolus</option>
                                    <option value="13">13 Chronic obstructive lung disease</option>
                                    <option value="14">14 Liver failure (other than 03, 03.1, 03.2)</option>
                                    <option value="15">15 Renal failure</option>
                                    <option value="16">16 Accident or other violent death (not suicide)</option>
                                    <option value="17">17 Suicide</option>
                                    <option value="18">18 Euthanasia</option>
                                    <option value="19">19 Substance abuse (active)</option>
                                    <option value="19.1">19.1 Chronic Alcohol abuse</option>
                                    <option value="19.2">19.2 Chronic intravenous drug-use</option>
                                    <option value="19.3">19.3 Acute intoxication (indicate agent)</option>
                                    <option value="20">20 Haematological disease (other causes)</option>
                                    <option value="21">21 Endocrine disease (other causes)</option>
                                    <option value="22">22 Psychiatric disease (other causes)</option>
                                    <option value="23">23 CNS disease (other causes)</option>
                                    <option value="24">24 Heart or vascular (other causes)</option>
                                    <option value="25">25 Respiratory disease (other causes)</option>
                                    <option value="26">26 Digestive system disease (other causes)</option>
                                    <option value="27">27 Skin and motor system disease (other causes)</option>
                                    <option value="28">28 Urogenital disease (other causes)</option>
                                    <option value="29">29 Obstetric complications</option>
                                    <option value="30">30 Congenital disorders</option>
                                    <option value="901">�������������� ���</option>
                                    <option value="90">90 Other causes</option>
                                    <option value="91">91 Unclassifiable causes</option>
                                    <option value="92">92 Unknown</option> -->
