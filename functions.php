<?php

/**
 * Twenty Fourteen CHILD functions and definitions
 */

/**** Include globals ****/
require_once('functions_globals.php');
/**** Include functions for component display ****/
require_once('functions_display_components.php');




// Style Status
# shortcode that takes parameter and applies visual style to it #
function style_to_status($status)
{
    extract(shortcode_atts(array(
        'status' => 'status'
    ), $status));

    //$status=[apr field="$status"];

    $style = "status_not_defined";
    switch ($status) {
        case "Complete":
            $style = "status_complete";
            break;
        case "In Progress":
            $style = "status_in_progress";
            break;
    }
    $status = "<span class='$style'>$status</span>";
    return $status;
}
add_shortcode('style_to_status', 'style_to_status');
# Example: [style_to_status status="Complete"] # 

function set_style_to_status($status, $type)
{

    $style = "status_not_defined";

    if (empty($status)) {
        $status = "Not Set";
    }
    switch ($status) {
        case "Not Started":
            $style = "status_not_started";
            break;
        case "Exploration":
            $style = "status_exploration";
            break;

        case "Definition":
            $style = "status_definition";
            break;
        case "In Progress":
            $style = "status_in_progress";
            break;
        case "Complete":
            $style = "status_complete";
            break;
        case "Blocked":
            $style = "status_blocked";
            break;
        case "Paused":
            $style = "status_paused";
            break;
        case "Canceled":
            $style = "status_canceled";
            break;
        case "NA":
            $style = "status_na";
            break;
    }






    if (!empty($type)) {
        switch ($type) {
            case "IA":
                $status = "IA";
                break;
            case "Design":
                $status = "DE";
                break;
            case "Design Technology":
                $status = "DT";
                break;
            case "Accessibility":
                $status = "AC";
                break;
        }
    }

    $status = "<span class='$style'>$status</span>";
    return $status;
}

function display_this_project_group($status, $these_projects)
{
    $return_this = "";
    if (!empty($these_projects)) {
        $style = "status_not_defined";
        switch ($status) {
            case "Not Started":
                $style = "status_not_started";
                break;
            case "Exploration":
                $style = "status_exploration";
                break;
            case "Definition":
                $style = "status_definition";
                break;
            case "In Progress":
                $style = "status_in_progress";
                break;
            case "Complete":
                $style = "status_complete";
                break;
            case "Blocked":
                $style = "status_blocked";
                break;
            case "Paused":
                $style = "status_paused";
                break;
            case "Canceled":
                $style = "status_canceled";
                break;
            case "NA":
                $style = "status_na";
                break;
        }
        $return_this = "<div class='$style'>$status</div>" . $these_projects;
    }

    return $return_this;;
}
function trim_display_date($d_time)
{
    $d_time = substr($d_time, 0, 10);
    if (empty($d_time)) {
        $d_time = "<em>date not set</em>";
    }
    return $d_time;
}

function check_jira_ticket($jira_ticket)
{
    if (empty($jira_ticket)) {
        $jira_ticket = "<em>No Jira link</em>";
    }
    return $jira_ticket;
}

function return_display_header($temp_title, $temp_edit_Link)
{
    $header = "<table><tr><td><h1 class='entry-title'>$temp_title</h1></td><td>$temp_edit_Link</td></tr></table>";
    return $header;
}
function make_markdown($content)
{

    $content = "[markdown]" . $content . "[/markdown]";
    $md_content = do_shortcode($content);
    // can I get rid of that maddening extra space?
    $md_content = rtrim($md_content);
    return $md_content;
}

function hello($status)
{

    $status = set_style_to_status($status);
    echo "ola 4 " . $status;
}

function return_project_card($card_wrap, $base_folder, $slug, $project_name, $portfolio, $portfolio_slug, $status, $launch_date, $project_description, $include_link, $include_edit, $record_id)
{
    $status = set_style_to_status($status, "");
    $launch_date = trim_display_date($launch_date);

    $project_description = make_markdown($project_description);

    $edit_link = "";
    if ($include_edit == "yes") {
        $edit_link = "<a href='" . $GLOBALS['projects_edit_link'] . $record_id . "/' target='new'>" . $GLOBALS['icon_edit'] . "</a>";
    }

    $project_card = $project_card . "<p class='what'>$project_description</p>";

    //include link to project? used from list of projects
    if ($include_link == "yes") {
        $link = "<a href='" . $base_folder . $slug . "/'><h2>" . $project_name . "</h2></a>";
        $project_card = $link . $project_card;
    } else {
        $link = "<h1 class='entry-title'>" . $project_name . "</h1>";
        $project_card = $link . $project_card;
    }
    //wrap in table
    $project_card = $project_card;


    $portfolio_link = "<a href='/portfolios/$portfolio_slug/'>$portfolio</a>";


    //wrap in div?
    if ($card_wrap == "yes") {
        $project_card = "<div class='cardwrapper'>" . $project_card . "</div>";
    }
    return $project_card;
}



function return_portfolio_card($card_wrap, $include_link, $base_folder, $slug, $prefix, $portfolio_name, $description, $areas_covered, $p_lead, $product_lead, $tech_lead, $UX_lead)
{


    $portfolio_card = "<tr>";
    $portfolio_card .= "<td colspan=2><span class='themsthebreaks'>" . $description . "</span></td>";
    $portfolio_card .= "</tr>";
    $portfolio_card .= "<tr>";
    $portfolio_card .= "<td><span class='themsthebreaks'>" . $areas_covered . "</span></td>";
    $portfolio_card .= "<td>";
    $portfolio_card .= "<strong>Portfolio Lead:</strong> " . $p_lead . "<br>";
    $portfolio_card .= "<strong>Product Lead:</strong> " . $product_lead . "<br>";
    $portfolio_card .= "<strong>Tech Lead:</strong> " . $tech_lead . "<br>";
    $portfolio_card .= "<strong>UX Lead:</strong> " . $UX_lead . "<br>";
    $portfolio_card .= "</td>";
    $portfolio_card .= "</tr>";


    //include title?
    if ($include_link == "yes") {
        $link = "<tr><td colspan=2><h2><a href='" . $base_folder . $slug . "/'>" . $prefix . ": " . $portfolio_name . "</h2></td></tr>";
        $portfolio_card = $link . $portfolio_card;
    }

    //wrap in table
    $portfolio_card = "<table>" . $portfolio_card . "</table>";

    //wrap in div?
    if ($card_wrap == "yes") {
        $portfolio_card = "<div class='cardwrapper'>" . $portfolio_card . "</div>";
    }

    return $portfolio_card;
}

function display_ia_design($link)
{
    // allows display of either figma embed code or plain link
    $display_this = "<em>No Figma file available</em> $link";

    // do I have a link?
    if (!empty($link)) {
        // Is this an embed already?
        if (strpos($link, 'iframe style') == true) {
            $display_this = $link;
        } else {
            $display_this = "<iframe style=\"border: none;\" width=\"800\" height=\"450\" src=\"https://www.figma.com/embed?embed_host=share&url=$link\" allowfullscreen></iframe>";
        }
    }
    return $display_this;
}


function return_page_placement_type($Temp_C_Manual_or_Auto)
{

    $C_Manual_or_Auto = "<Span class='urgent_message'>Not Set</span>";

    switch ($Temp_C_Manual_or_Auto) {
        case "Manual Required":
            $C_Manual_or_Auto = "MR";
            break;
        case "Manual Optional":
            $C_Manual_or_Auto = "MO";
            break;
        case "Auto":
            $C_Manual_or_Auto = "A";
            break;
        case "Open Issue":
            $C_Manual_or_Auto = "<Span class='urgent_message'>OI</span>";
            break;
    }

    return $C_Manual_or_Auto;
}

function return_image_base_type_details($e, $attr_lu)
{
    //ATTR Image
    // Has to be a better way to do this
    $query_basetype = new AirpressQuery("ATTR Image", CONFIG_NAME);
    $query_basetype->filterByFormula("{C_T_C_ID}='$attr_lu'");
    //$query->sort("Order","asc");
    $basetypedetails = new AirpressCollection($query_basetype);

    $basedetails = "";
    if (count($basetypedetails) != 0) {
        foreach ($basetypedetails as $btd) {
            //$basedetails.=$attr_lu." <span class='attribute_detail'>Ratio</span>= ".$btd["Ratio"];
            $basedetails .= "<strong>" . $btd["Description"] . "</strong>";
            $basedetails .= "<br><span class='attribute_detail'>Image Source</span>= " . $btd["Image Source"];

            if (($btd["Image Source"] == "Programmatic") && (!empty($btd["Programmatic Detail"]))) {

                $btd_other = ": " . $btd["Programmatic Detail"];
                $basedetails .= $btd_other;
            }

            $btd_required = $btd["Required"];

            $basedetails .= "<br><span class='attribute_detail'>Required</span>= " . $btd_required;

            $basedetails .= "<br><span class='attribute_detail'>Max File Size</span>= " . $btd["Max File Size"];

            $basedetails .= "<br><span class='attribute_detail'>Alt Text</span>= " . $btd["Alt Text"];

            if (!empty($btd["Other"])) {
                $btd_other = make_markdown($btd["Other"]);
                $btd_other = "<br><span class='attribute_detail'>Other</span>= " . $btd_other;
                $basedetails .= $btd_other;
            }
        }

        // add link to edit
        $btf_edit_url = "<br><a href='https://airtable.com/tblYg2OiTSd2ZMqlH/viwaF0S0MYwMPdDyp/" . $btd["Record ID"] . "?blocks=hide' target='new'>" . $GLOBALS['icon_edit'] . "</a>";
        $basedetails .= $btf_edit_url;
    } else {
        $basedetails = "<br><a href='https://airtable.com/shr4cQfma6bxsJZzQ?prefill_C_T_C_ID=" . $attr_lu . "' target='new'>add rules</a>";
    }

    return $basedetails;
}

function return_text_base_type_details($e, $attr_lu)
{
    //ATTR Text
    // Has to be a better way to do this
    $query_basetype = new AirpressQuery("ATTR Text", CONFIG_NAME);
    $query_basetype->filterByFormula("{C_T_C_ID}='$attr_lu'");
    //$query->sort("Order","asc");
    $basetypedetails = new AirpressCollection($query_basetype);
    $oy = count(basetypedetails);
    $basedetails = "";

    if (count($basetypedetails) != 0) {
        foreach ($basetypedetails as $btd) {


            $basedetails .= "<strong>" . $btd["Description"] . "</strong>";
            $basedetails .= "<br><span class='attribute_detail'>Source</span>= " . $btd["Source"];
            if (!empty($btd["Source Other"])) {
                $basedetails .= ": " . $btd["Source Other"];
            }
            if ($btd["Max Char Count"] != "Other") {
                $basedetails .= "<br><span class='attribute_detail'>Max Char Count</span>= " . $btd["Max Char Count"];
            } else {
                $basedetails .= "<br><span class='attribute_detail'>Max Char Count</span>= " . $btd["Max Char Count Other"];
            }

            $btd_required = "Optional";
            if (!empty($btd["Required"])) {
                $btd_required = "Required";
            }
            $basedetails .= "<br><span class='attribute_detail'>Required</span>= " . $btd_required;
            $btd_other = "";


            if (!empty($btd["Restricted Options"])) {
                $btd_restricted_options = make_markdown($btd["Restricted Options"]);
                $btd_restricted_options = "<br><span class='attribute_detail'>Restricted Options</span>" . $btd_restricted_options;
                $basedetails .= $btd_restricted_options;
            }

            if (!empty($btd["Format"])) {
                $btd_other = "<br><span class='attribute_detail'>Format</span>" . $btd["Format"];
                $basedetails .= $btd_other;
            }

            if (!empty($btd["Other"])) {
                $btd_other = make_markdown($btd["Other"]);
                $btd_other = "<br><span class='attribute_detail'>Other</span>" . $btd_other;
                $basedetails .= $btd_other;
            }

            // add link to edit
            $btf_edit_url = "<br><a href='https://airtable.com/tblePLqv2aDKw7Rym/viwqeJudVgWumy4L4/" . $btd["Record ID"] . "?blocks=hide' target='new'>" . $GLOBALS['icon_edit'] . "</a>";
            $basedetails .= $btf_edit_url;
        }
    } else {

        $basedetails = "<br><a href='https://airtable.com/shrrDBKp11S8N2zPy?prefill_C_T_C_ID=" . $attr_lu . "' target='new'>add rules</a>";
    }
    return $basedetails;
}
function return_button_base_type_details($e, $attr_lu)
{
    // Has to be a better way to do this
    $query_basetype = new AirpressQuery("ATTR Button", CONFIG_NAME);
    $query_basetype->filterByFormula("{C_T_C_ID}='$attr_lu'");
    //$query->sort("Order","asc");
    $basetypedetails = new AirpressCollection($query_basetype);


    $basedetails = "";
    if (count($basetypedetails) != 0) {
        foreach ($basetypedetails as $btd) {
            $basedetails .= "<strong>" . $btd["Description"] . "</strong>";
            $basedetails .= "<br><span class='attribute_detail'>Text</span>= " . $btd["Text"];
            $basedetails .= "<br><span class='attribute_detail'>Type</span>= " . $btd["Type"];
            $basedetails .= "<br><span class='attribute_detail'>Icon and Placement</span>= " . $btd["Icon and Placement"];
            $basedetails .= "<br><span class='attribute_detail'>Destination</span>= " . $btd["Destination"];


            $btd_other = "";
            if (!empty($btd["Other"])) {
                $btd_other = make_markdown($btd["Other"]);
                $btd_other = "<br><span class='attribute_detail'>Other</span>= " . $btd_other;
            }

            $basedetails .= $btd_other;
        }
        // add link to edit
        $btf_edit_url = "<br><a href='https://airtable.com/tblugJwJ7ygYkwvg6/viwGFHAr0EzIaXItO/" . $btd["Record ID"] . "?blocks=hide' target='new'>" . $GLOBALS['icon_edit'] . "</a>";
        $basedetails .= $btf_edit_url;
    } else {

        $basedetails = "<br><a href='https://airtable.com/shr4w4cEtqKXU4gnq?prefill_C_T_C_ID=" . $attr_lu . "' target='new'>add rules</a>";
    }
    return $basedetails;
}

function return_list_base_type_details($e, $attr_lu)
{
    //ATTR Text
    // Has to be a better way to do this
    $query_basetype = new AirpressQuery("ATTR List", CONFIG_NAME);
    $query_basetype->filterByFormula("{C_T_C_ID}='$attr_lu'");
    //$query->sort("Order","asc");
    $basetypedetails = new AirpressCollection($query_basetype);


    $basedetails = "";
    if (count($basetypedetails) != 0) {
        foreach ($basetypedetails as $btd) {
            $basedetails .= "<strong>" . $btd["Description"] . "</strong>";
            $basedetails .= "<br><span class='attribute_detail'>Type</span>= " . $btd["Type"];
            $basedetails .= "<br><span class='attribute_detail'>List Item Component</span>= " . $btd["List Item Component"];
            $basedetails .= "<br><span class='attribute_detail'>Number of Items</span>= " . $btd["Number of Items"];
            $basedetails .= "<br><span class='attribute_detail'>Source</span>= " . $btd["Source"];

            $btd_other = "";
            if (!empty($btd["Other"])) {
                $btd_other = make_markdown($btd["Other"]);
                $btd_other = "<br><span class='attribute_detail'>Other</span>= " . $btd_other;
            }

            $basedetails .= $btd_other;
        }
        // add link to edit
        $btf_edit_url = "<br><a href='https://airtable.com/tblugJwJ7ygYkwvg6/viwGFHAr0EzIaXItO/" . $btd["Record ID"] . "?blocks=hide' target='new'>" . $GLOBALS['icon_edit'] . "</a>";
        $basedetails .= $btf_edit_url;
    } else {

        $basedetails = "<br><a href='https://airtable.com/shrgNw81v9447uqG4?prefill_C_T_C_ID=" . $attr_lu . "' target='new'>add rules</a>";
    }
    return $basedetails;
}

function return_placement_details($Record_ID, $Source, $Source_Other, $Placed_Accessibility, $Placed_Functionality, $Placement_Description, $Placement_Optional, $Placement_Parameters, $Placement_Details)
{


    $Placement_Parameters = make_markdown($Placement_Parameters);

    $C_Placment_Details_Edit_Link = "<a href='https://airtable.com/tblUQUA6r9AahQ73M/viwFA50LUglw6UlCB/" . $Record_ID . "?blocks=hide' target='new'>" . $GLOBALS['icon_edit'] . "</a>";
    $div_bg = " ";
    if ($Placement_Optional == "Optional") {
        $div_bg = " class='optional' ";
    }


    // FIX need to make this smarter
    if (isset($Source)) {
        if (isset($Source_Other)) {
            $Source .= " " . $Source_Other;
        }

        $Source = "<span class='attribute_detail' >Source</span> " . $Source;
    }

    ///FIX
    if (isset($Placement_Parameters)) {
        $Placement_Parameters = "<br>" . $Placement_Parameters;
    }
    if (isset($Source)) {
        $Source = "<br>" . $Source;
    }
    if (isset($C_Primary_Parameters)) {
        $C_Primary_Parameters = "<br>" . $C_Primary_Parameters;
    }
    if (isset($C_Primary_Max_Char)) {
        $C_Primary_Max_Char = "<br>" . $C_Primary_Max_Char;
    }
    if (isset($Placement_Text_Format)) {
        $Placement_Text_Format = "<br>" . $Placement_Text_Format;
    }
    if (isset($Placement_Details)) {
        $Placement_Details = "<br>" . $Placement_Details;
    }
    //"<span class='component_number'>".$Placement_Description."</span>".
    $C_Sub_Definition_Details = $Placement_Parameters . $Source . $C_Primary_Parameters . $C_Primary_Max_Char . $Placement_Text_Format . $Placement_Details;

    $placement_details = "<table $div_bg>";
    $placement_details .= "<tr $div_bg>";
    $placement_details .=  "<td colspan=2><h5>Placement Details " . $C_Placment_Details_Edit_Link . "</h5>" . $C_Primary_Details . "<br>" . $C_Primary_Attributes_Notes . "</td>";
    $placement_details .=  "</tr>";
    $placement_details .=  "<tr>";
    $placement_details .=  "<td width='40%'>" . $C_Sub_Definition_Details . "</td><td><span class='section_header'>Contextual Functionality</span><br>" . $Placed_Functionality . "<br><br><span class='section_header'>Contextual Accessibility</span><br>" . $Placed_Accessibility . "</td>";
    $placement_details .=  "</tr>";

    $placement_details .=  "</table>";
    return $placement_details;
}

function wpb_list_child_pages()
{

    global $post;

    if (is_page() && $post->post_parent)

        $childpages = wp_list_pages('sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0');
    else
        $childpages = wp_list_pages('sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0');

    if ($childpages) {

        $string = '<ul>' . $childpages . '</ul>';
    }

    return $string;
}

add_shortcode('wpb_childpages', 'wpb_list_child_pages');
