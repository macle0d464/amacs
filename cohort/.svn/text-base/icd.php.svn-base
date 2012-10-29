<?php
global $in_script_tag;
$to_write = "";
$tag = "";
$in_script_tag = false;

function check_tag($tag)
{
	if ($tag  == "</SCRIPT>")
	{
		$in_script_tag = false;
		return false;
	}
	elseif ($tag == "<SCRIPT TYPE=\"text/JavaScript\">")
	{
		$in_script_tag = true;
		return true;
	}
	else
	{
		//echo substr($tag, 1);
		echo $tag;
	}
}

$handle = fopen("gi26.htm", "r");
while (false !== ($char = fgetc($handle)))
{
	if ($char == "<")
	{
		$tag = $char;
		$tag_opened = true;
	}
	elseif ($char == ">")
	{
		$tag .= $char;
		$tag_opened = false;
		$in_script_tag = check_tag($tag);
	}
	else
	{
		if ($tag_opened)
		{
			$tag .= $char;
		}	
		else
		{
			if  (!$in_script_tag)
			{
				echo $char;
			}
		}
	}	
}
fclose($handle);
?>