<?php
if (isset($_GET['page']))
{
$field = $_GET['field'];
$page = $_GET['page'];
$fhandle = fopen($page, 'r');

if (!$fhandle) {
   echo 'Could not open file '.$page;
}

while (false !== ($c = fgetc($fhandle)))
{
	if ($c == "<")
	{
		$tag = "";
		$tag_opened = true;
	}
	if ($c == ">")
	{
		$tag_opened = false;
		$tag_just_closed = true;
		$tag .= $c;
		if ($tag == "<SCRIPT TYPE=\"text/JavaScript\">")
		{
			while (false !== ($c = fgetc($fhandle)))
			{
				if ($c == "<")
				{
					$tag = "<";
				}
				elseif ($c == ">")
				{
					$tag .= $c;
					if ($tag == "</SCRIPT>")
					{
//						echo "<!-- Removed SCRIPT tag -->\n";
						echo "<SCRIPT TYPE=\"text/JavaScript\">\n";
						echo "function returnValue(code)";
						echo "{";
						echo "window.opener.document.all['$field'].value = code;";
						echo "}";
						echo "</SCRIPT>";
						$tag = "";
						break;
					}
				}
				else
				{
					$tag .= $c;	
				}
			}		
		}
		if (strpos($tag, "NAME"))
		{
			$place = strpos($tag, "NAME=");
			$temp = substr($tag, $place+6, strlen($tag));
			//echo $temp;
			$name = strtoupper(substr($temp, 0, strpos($temp, "\"")));
		}
		else
		{
			$name = "";
		}
		if (strpos($tag, "HREF=") && (!strpos($tag, "css"))) 
		{
			// Link is already defined for an external page and link is not styelsheet
			// TODO: fix bookmark links, NAME=
			$place = strpos($tag, "HREF=");
			$temp = substr($tag, $place+6, strlen($tag));
			$href = substr($temp, 0, strpos($temp, "\""));
			list($href_page, $href_bookmark) = split("#", $href);
			if ($href[0] == "#")
			{
				echo $tag;
			}
			else
			{
				echo "<A HREF='showpage.php?field=$field&page=$href'>";
			}			
/*			if ($href_bookmark == "")
			{
				echo "<A HREF='showpage.php?field=$field&page=$href_page'>";
			}
			else
			{
				echo "<A HREF='showpage.php#$href_bookmark?field=$field&page=$href_page'>";
			}		*/
		}
		else 
		{
			if (strlen($name) == 4) 
			{
				// TODO: fix bookmark links, NAME=
				echo "<A мале=\"".$name."\"></A>";
				echo "<A HREF='#$name' onclick='javascript:returnValue(\"$name\");'>";
				echo substr($name,0,3).".".substr($name,3,1);
				echo "</A>";
				$count = 1;
				while (false !== ($c = fgetc($fhandle)))
				{
						if ($c == "<")
						{
							$tag = "";
							$tag_opened = true;
							if ($count == 2)
							{
								break;
							}
							$count++;
						}			
				}
			}
			elseif ((strlen($name) == 3) && ($page != "navi.htm")) 
			{
				// TODO: fix bookmark links, NAME=
				echo "<A мале=\"".$name."\"></A>";
				echo "<A HREF='#$name' onclick='javascript:returnValue(\"$name\");' style='color: white'>";
				echo substr($name,0,3);
				echo "</A>";
				$count = 1;
				while (false !== ($c = fgetc($fhandle)))
				{
						if ($c == "<")
						{
							$tag = "";
							$tag_opened = true;
							if ($count == 2)
							{
								break;
							}
							$count++;
						}			
				}
			}			
			else // Don't create hyperlink, the A tag is a header
			{
				echo $tag;
			} 
		}
	}
	if (!$tag_opened)
	{
		if ($tag_just_closed)
		{
			$tag_just_closed = false;
		}
		else
		{
			echo $c;
		}
	}
	else
	{
		$tag .= $c;
	}
}
fclose($fhandle);
}
else
{
?>

<FORM METHOD=GET action="showpage.php">
<input type="text" id="page" style="font-family: courier new" size="10"
name="page" value="gc00.htm"/>
<input type="submit" style="font-family: courier new"/>
</form>

<?php
}
?>