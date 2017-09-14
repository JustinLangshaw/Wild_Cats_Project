<?php


function AnyoneAttempteddd($AnyoneAttempted='')
{
	global $link;

	$yesno = array("Yes", "No");

	print "\n\n\n<select name='AnyoneAttempted'>\n
	<option name=''> </option>";
		for($i=0; $i<count($yesno); $i++)
		{
			if($AnyoneAttempted == $yesno[$i])
			{
				print "\n<option value='$yesno[$i]' selected='selected'>$yesno[$i]</option>";
			}
			else
			{
				print "\n<option value='$yesno[$i]'>$yesno[$i]</option>";
			}
		}
		
	print "</select>\n\n\n";
}

function ShowReportColony()
{
	
	global $link;
		
}

?>