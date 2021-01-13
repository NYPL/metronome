<?php


function return_placed_component_details($placed_in, $placement_id, $record_id, $number, $man_auto, $placement_reason, $placement_rules, $component_name, $C_Slug, $component_description, $accessibility, $functional_specs, $c_detail_All, $optional)
{

    $component_description = make_markdown($component_description);
    $accessibility = make_markdown($accessibility);
    $functional_specs = make_markdown($functional_specs);

    $temp_view_Link = $GLOBALS['components_base_folder'] . $C_Slug . "/";
    $temp_view_Link = "<a href='" . $temp_view_Link . "'>" . $component_name . "</a>";

    $temp_edit_Link = "<a href='" . $GLOBALS['components_edit_link'] . $record_id . "?blocks=hide' target='new'>" . $GLOBALS['icon_edit'] . "</a>";

    //eiting placement details
    if ($placed_in == "Component") {
        $placed_component_edit_link = "<a href='" . $GLOBALS['placed_c_in_c_edit_link'] . $placement_id . "?blocks=hide' target='new'>" . $GLOBALS['icon_edit'] . "</a>";
    } else {
        $placed_component_edit_link = "<a href='" . $GLOBALS['templates_rule_and_details_edit_link'] . $placement_id . "?blocks=hide' target='new'>" . $GLOBALS['icon_edit'] . "</a>";
    }


    $first_border = "class='bottom_border '";
    if (!empty($placement_rules)) {
        $placement_rules = make_markdown($placement_rules);
        $placement_rules = "<tr ><td >&nbsp;</td><td >&nbsp;</td><td colspan=2 class='placement_details'><span class='section_header'>Placement Details & Rules</span>" . $placement_rules . "</td></tr>";
        $first_border = "class=' '";
    }

    // am I optional?
    if (($optional == "Optional") || ($optional == "Manual Optional")) {
        $status_message .= "<tr><td colspan=2 xclass='optional_item'>&nbsp;</td><td colspan=2 class='optional_item'>This component is optional</td></tr>";
    }
    // Do I have my own placed components?
    $my_placed_components = "";

    $query_for_placed_components = new AirpressQuery("Component to Component LookUp", $GLOBALS['config_name']);
    $filter_formula = "{Container Component}='$component_name' ";
    $query_for_placed_components->filterByFormula($filter_formula);
    $query_for_placed_components->sort("Order", "asc");
    $placed_components = new AirpressCollection($query_for_placed_components);
    $placed_components->populateRelatedField("Placed Component", "Components");
    foreach ($placed_components as $placed) {
        //what fields do I need
        $CP_Name = $placed["Placed Component"][0]["ComponentName"];
        $CP_Slug = $placed["Placed Component"][0]["Slug"];
        $CP_Placement = $placed["Placement Description"];


        $CP_view_Link = $GLOBALS['components_base_folder'] . $CP_Slug . "/";
        $CP_view_Link = $CP_Placement . " -  <a href='" . $CP_view_Link . "'>" . $CP_Name . "</a>";

        $my_placed_components .= $CP_view_Link . " | ";
    }
    if ($my_placed_components == "") {
        $my_placed_components = "<em>No subcomponents</em>";
    } else {
        $my_placed_components = "<strong>Uses Components</strong>: " . $my_placed_components;
    }
    // Build set of rows to return
    $return_this = "";
    $return_this .= "<tr><td  class='bottom_border_thick'><span class='component_number'>" . $number . "</span></td><td  class='bottom_border_thick'><span class='manual_or_auto'>" . $man_auto . "</span></td><td colspan=2  class='bottom_border_thick'><span class='placement_reason'>" . $placement_reason . "</span>  " . $placed_component_edit_link . "</td></tr>";


    $return_this .= $status_message;
    $return_this .= $placement_rules;

    $return_this .= "<tr ><td>&nbsp;</td><td>&nbsp;</td><td><strong>" . $temp_view_Link . "</strong></td></tr>";

    $return_this .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td colspan=2>" . $component_description . "</td></tr>";


    // link to edit parameters and details
    $edit_all_para_and_details = "<a href='" . $GLOBALS['components_parameters_and_details_edit_link'] . $record_id . "?blocks=hide' target='new'>" . $GLOBALS['icon_edit'] . "</a>";

    $return_this .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td><span class='section_header'>Functional Specs</span>" . $functional_specs . "<br><span class='section_header'>Accessibility</span>" . $accessibility . "</td></tr>";

    $return_this .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td colspan=2>" . $my_placed_components . "</td></tr>";
    $return_this .= "<tr><td colspan=4>&nbsp;</td></tr>";


    return $return_this;
}


function return_my_parameters($e)
{
    $my_parameters = "";

    $my_record_id = $e["Record ID"];
    // General - these could apply in a number of cases
    $my_parameters .= return_parameter_detail($e["GEN: States"], "None", "States");

    $my_source = return_parameter_detail($e["GEN: Source"], "Undefined", "Source");
    if (!empty($e["GEN: Source Details"])) {
        $my_source .= ": " . $e["GEN: Source Details"];
    }
    $my_parameters .= $my_source;

    // By Type - these are restricted by type
    // TEXT
    //$my_parameters.="<br><span class='section_header'>For this type</span>";
    $my_parameters .= return_parameter_detail($e["TEXT: Format"], "Undefined", "Text Format");


    $my_max_char = return_parameter_detail($e["TEXT: Max Character Count"], "Undefined", "Max Char");
    if (!empty($e["TEXT: Max Character Count Other"])) {
        $my_max_char .= ": " . $e["TEXT: Max Character Count Other"];
    }
    $my_parameters .= $my_max_char;
    $my_parameters .= return_parameter_detail($e["TEXT: Link"], "Undefined", "Text Link");
    $my_parameters .= return_parameter_detail($e["TEXT: Link Destination"], "Undefined", "Text Link Destination");

    // IMAGES
    $my_parameters .= return_parameter_detail($e["IMAGE: Ratio"], "Undefined", "Image Ratio");
    $my_parameters .= return_parameter_detail($e["IMAGE: Width"], "Undefined", "Image Width");
    $my_parameters .= return_parameter_detail($e["IMAGE: Caption"], "Undefined", "Image Caption");
    $my_parameters .= return_parameter_detail($e["IMAGE: Credit"], "Undefined", "Image Credit");

    $my_parameters .= return_parameter_detail($e["LIST: Title"], "Undefined", "Title");
    $my_parameters .= return_parameter_detail($e["LIST: Number of Items"], "Undefined", "Number of Items");
    $my_parameters .= return_parameter_detail($e["LIST: Link"], "Undefined", "Link");

    // BUTTONS

    $my_parameters .= return_parameter_detail($e["BUTTON: Type"], "Undefined", "Button Type");
    $my_parameters .= return_parameter_detail($e["BUTTON: Icon and Placement"], "Undefined", "Button Icon and Placement");
    $my_parameters .= return_parameter_detail($e["BUTTON: Text"], "Undefined", "Button Text");
    $my_parameters .= return_parameter_detail($e["BUTTON: Action"], "Undefined", "Button Action");



    // Other Parameters
    $my_other = return_parameter_detail($e["GEN: Other Parameters and Rules"], "Undefined", "Parameters<br>");
    $my_parameters .= make_markdown($my_other);






    if (empty($my_parameters)) {
        $my_parameters = "no parameters found";
    }
    return $my_parameters;
}

function return_parameter_detail($value, $default, $title)
{
    //Only show if set
    $this_parameter = "";
    if (!empty($value)) {
        $this_parameter = "<span class='attribute_detail'>" . $title . "</span> " . $value . "<br>";
    }
    return $this_parameter;
}

function return_display_item_header($type, $temp_title, $record_id, $description, $C_React_Storybook, $React_Code, $C_Twig_Storybook, $C_Twig_Code, $C_Primary_Func_Specs, $C_Primary_Accessibility, $these_parameters, $figma)
{


    $description = make_markdown($description);
    $C_Primary_Func_Specs = make_markdown($C_Primary_Func_Specs);
    $C_Primary_Accessibility = make_markdown($C_Primary_Accessibility);

    // display status bar	
    $status_table = "<table class='status_bar'><tr>";
    $status_table .= "<td><strong>React</strong>:" . $C_React_Storybook . " | " . $React_Code . "</td>";
    $status_table .= "<td><strong>Twig</strong>: " . $C_Twig_Storybook . " | " . $C_Twig_Code . "</td>";
    $status_table .= "<td>&nbsp;</td>";
    $status_table .= "</tr></table>";

    // link to edit main details

    if ($type == "Component") {
        $temp_edit_Link = $GLOBALS['components_edit_link'];
    } else {
        $temp_edit_Link = $GLOBALS['templates_edit_link'];
    }

    $temp_edit_Link = "<a href='" . $temp_edit_Link . $record_id . "?blocks=hide' target='new'>" . $GLOBALS['icon_edit'] . "</a>";

    // link to edit parameters and details (not shown for template)
    $edit_all_para_and_details = "<a href='" . $GLOBALS['components_parameters_and_details_edit_link'] . $record_id . "?blocks=hide' target='new'>" . $GLOBALS['icon_edit'] . "</a>";

    $header .= "<tr><td><h1 class='entry-title'>$temp_title </h1></td></tr>";
    $header .= "<tr><td>$description</td></tr>";
    $header .= "<tr><td>$status_table</td></tr>";

    $figma = // display_ia_design($figma);
    $header .= "<tr><td><strong>Design & Schematic</strong><br><a href='" . $figma . "'>".$figma."</a><br></td></tr>";


    if ($type == "Component") {
        $header .= "
            <tr><td><span class='section_header'>Functional Specs</span><br>$C_Primary_Func_Specs</td></tr>
            <tr><td><span class='section_header'>Accessibility</span><br>$C_Primary_Accessibility</td></tr>
            <tr><td><span class='section_header'>CHANGELOG</span><br>$these_parameters</td></tr>";
    }

    $header .= "</table>";
    return $header;
}

function return_project_item_row($t_link, $t_name, $t_description)
{


    // Description	
    //trim description if too long
    if (strlen($t_description) > 150) {
        $t_description = substr($t_description, 0, 150) . "...";
    }
    $t_description = make_markdown($t_description);

    $t_row .= "<tr>";
    $t_row .= "<td><h4><a href='" . $t_link . "'>" . $t_name . "</a></h4></td>";
    $t_row .= "</tr>";

    $t_row .= "<tr>";
    $t_row .= "<td colspan=2>" . $t_description . "</td>";
    $t_row .= "</tr>";

    return $t_row;
}

function getCacheFileLocation($cacheFileName) {
    
    $themeDir = __DIR__;
    
    $dirPieces = explode('/themes/', $themeDir);
    
    $contentRoot = $dirPieces[0];

    $cacheDir = $contentRoot . '/airpress_cache';
    
    $cacheFileName = str_replace('/','', $cacheFileName);

    return $cacheDir . '/' . $cacheFileName;
}

function isCacheValid($cacheFileLocation) {

    // clear cache on demand with query string var
    
    if(isset($_GET['fresh'])) {
        unlink($cacheFileLocation);
    }

    $cacheCreatedTime = filemtime($cacheFileLocation);

    $cacheExpires = 3600;

    return $cacheCreatedTime > (time() - $cacheExpires);

}

function readCache($cacheFileLocation) {

    $cacheCreatedTime = filemtime($cacheFileLocation);
    
    $offset = timezone_offset_get(new DateTimeZone('America/New_York'), new DateTime());
    
    $code = "<p style=\"display:block;float:right;\">Cached " . 
        date("M j Y g:i:s a", $cacheCreatedTime + $offset) . 
        " - <a href=\"" . $_SERVER['REQUEST_URI'] . '?fresh=true' . "\">Clear cache</a> </p>";
    
    $code .= file_get_contents($cacheFileLocation);
    
    return $code;

}

function writeCache($cacheFileLocation, $code) {
    
    file_put_contents($cacheFileLocation, $code);
    
    echo "<p>Cache Written</p>";
}

