
		//// My Core Attributes
		$C_Sub_Attributes_Notes=$e["Placed Component"][0]["Attributes Notes"];
		$C_Sub_Func_Specs=$e["Placed Component"][0]["FunctionalSpecs"];
		$C_Sub_Accessibility=$e["Placed Component"][0]["Accessibility"];
		$C_Sub_Details=$e["Placed Component"][0]["Details"];
		$C_Sub_States=$e["Placed Component"][0]["States"];
		$C_Sub_Parameters=$e["Placed Component"][0]["Parameters"];
		$C_Sub_Record_ID=$e["Placed Component"][0]["Record ID"];
		$C_Sub_Max_Char=$e["Placed Component"][0]["TEXT: Max Character Count"];
		$C_Sub_Max_Char_Other=$e["Placed Component"][0]["TEXT: Max Character Count Other"];
		
		$C_Sub_Text_Format=$e["Placed Component"][0]["TEXT: Format"];
		
		$C_Sub_Definition=return_component_definition("Sub", $C_Sub_Attributes_Notes, $C_Sub_Func_Specs,$C_Sub_Accessibility, $C_Sub_Details, $C_Sub_States, $C_Sub_Parameters, $C_Sub_Record_ID, $C_Sub_Max_Char, $C_Sub_Max_Char_Other, $C_Sub_Text_Format );
		
		//My Placement Details
		 $Source=$e["Source"];
		$Source_Other=$e["Source Other"];
		$Placed_Accessibility=$e["Placed Accessibility"];
		$Placed_Functionality=$e["Placed Functionality"];
		$Placement_Description=$e["Placement Description"];
		$Placement_Optional=$e["Optional"];
		$Placement_Parameters=$e["Placed Parameters"];
		$Placement_Details=$e["Details"];
		
	
		// send my CtoC ID
		$C_Placement_Details=return_placement_details($e["Record ID"], $Source, $Source_Other, $Placed_Accessibility, $Placed_Functionality, $Placement_Description, $Placement_Optional, $Placement_Parameters, $Placement_Details);
		
		$these_details=return_placed_component_details($e["Record ID"], $e["Order"], $C_Manual_or_Auto, $Placement_Description, $IA_Status, $Design_Status, $Design_Tech_Status, $$C_Name, $C_Slug, $component_description, $accessibility, $functional_specs, $c_detail_All);
		
		echo "<table><tr><td>$these_details</td></tr></table>";
		echo "<tr $div_bg>";
			echo "<td rowspan=4><span class='component_number'>".$e["Order"]."</span><br><strong>".$C_Manual_or_Auto."</strong></td>";
			echo "<td colspan=2 ><span class='component_number'>$Placement_Description</span><a href='".$T_View_Link."'><h4>".$C_Name."</a></h4></td>";
			echo "<td style='text-align:right;'>".$IA_Status.$Design_Status.$Design_Tech_Status.$C_Edit_Link."</td>";
		echo "</tr>";
		
		
		echo "<tr $div_bg>";
			echo "<td colspan=3>".$C_Description."</td>";
		echo "</tr>";
		
		echo "<tr $div_bg>";
			echo "<td colspan=3>".$C_Sub_Definition."</td>";
		echo "</tr>";
		echo "<tr $div_bg>";
			echo "<td colspan=3>".$C_Placement_Details."</td>";
		echo "</tr>";
		
		
		//echo "<tr $div_bg>";
		//	echo "<td><strong>".$C_Manual_or_Auto."</strong></td>";
		//	echo "<td width='40%'>".$basedetails."</td>";
		//	echo "<td >&nbsp;</td>";
		//	echo "<td ><span class='section_header'>Placement Details: </span><br><span class='section_header'>Functional Specs</span>".$C_Func_Specs."<br><span class='section_header'>Accessibility</span>".$C_Accessibility."</td>";
		//echo "</tr>";
		
		
			
		
		// I see you bad spacer!
		echo "<tr>";
			echo "<td colspan=3>&nbsp;</td>";
		echo "</tr>";<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
</body>
</html>