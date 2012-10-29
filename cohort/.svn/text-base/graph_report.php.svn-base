<?php
require 'Image/Graph.php';
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');    

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	session_start();
	$cd4_query = "SELECT ExamDate,AbsoluteCD4 FROM exams_anosologikes WHERE PatientCode=890";//.$_SESSION['PatientCode'];
	
    // create the graph
    $Graph =& Image_Graph::factory('graph', array(500, 400));
    // add a TrueType font
    $Font =& $Graph->addNew('ttf_font', 'Gothic');
    // set the font size to 11 pixels
    $Font->setSize(8);
    
    $Graph->setFont($Font);

    $Graph->add(
        Image_Graph::vertical(
            Image_Graph::factory('title', array('CD4 Graph', 12)),        
            Image_Graph::vertical(
                $Plotarea = Image_Graph::factory('plotarea'),
                $Legend = Image_Graph::factory('legend'),
                90
            ),
            5
        )
    );   

    $Legend->setPlotarea($Plotarea);
            
    // create the dataset
    $Dataset =& Image_Graph::factory('random', array(10, 2, 15, true));
    // create the 1st plot as smoothed area chart using the 1st dataset
    $Plot =& $Plotarea->addNew('Image_Graph_Plot_Smoothed_Area', &$Dataset);
    
    // set a line color
    $Plot->setLineColor('gray');

    // set a standard fill style    
    $Plot->setFillColor('red@0.2');

$result = execute_query($cd4_query);
$n = mysql_num_rows($result);
$Dataset2 =& Image_Graph::factory('dataset');
for ($i=0; $i<$n; $i++)
{
	$row = mysql_fetch_array($result);
	$Dataset2->addPoint($row[0], $row[1]);
	$test[$row[0]] = show_date($row[0]);
}
//	$Dataset2->addPoint(2, 41);
//	$Dataset2->addPoint(3, 78);
//	$Dataset2->addPoint(4, 12); 
     $Plot2 =& $Plotarea->addNew('Image_Graph_Plot_Smoothed_Area', &$Dataset2, IMAGE_GRAPH_AXIS_Y_SECONDARY);
         $Plot2->setLineColor('gray');

    // set a standard fill style    
    $Plot2->setFillColor('blue@0.2');
    // output the Graph
    $AxisX = $Plotarea->getAxis(IMAGE_GRAPH_AXIS_X);
    $AxisX->setDataPreprocessor(Image_Graph::factory('Image_Graph_DataPreprocessor_Array', array($test)));
    $Graph->done();

mysql_close($dbconnection);     
?>