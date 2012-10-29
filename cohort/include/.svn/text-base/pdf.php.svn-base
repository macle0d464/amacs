<?
	if($action=="getpdf")
	{
		mysql_connect("localhost","root","97103");
		mysql_select_db("cdcol");

		include ('class.ezpdf.php');
		$pdf =& new Cezpdf();
		$pdf->selectFont('../pdf/fonts/Helvetica');

		$pdf->ezText('CD Collection',14);
		$pdf->ezText('© 2002/2003 Kai Seidler, oswald@apachefriends.org, GPL',10);
		$pdf->ezText('',12);

		$result=mysql_query("SELECT id,titel,interpret,jahr FROM cds ORDER BY interpret;");
		
		$i=0;
		while( $row=mysql_fetch_array($result) )
		{
			$data[$i]=array('interpret'=>$row['interpret'],'titel'=>$row['titel'],'jahr'=>$row['jahr']);
			$i++;
		}

		$pdf->ezTable($data,"","",array('xPos'=>'left','xOrientation'=>'right','width'=>500));

		$pdf->ezStream();
		exit;

	}
?>
