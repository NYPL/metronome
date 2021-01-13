<?php

// $base_url="http://themetronome.co";
//STAGING
$base_url = "http://themetronome.co";


$GLOBALS['config_name'] = "NYPLdoc2";

//// PROJECTS ////
$GLOBALS['projects_base_folder'] = $base_url . "/projects/";

$GLOBALS['epics_base_folder'] = $base_url . "/epics/";

// link to open specific project in airtable for editing, uses Record_ID
$GLOBALS['projects_edit_link'] = "https://airtable.com/tblbFF9urE24fqiVs/viw4VhxrCWn657ezj/";
// link to add a related doc, opens in airtable
$GLOBALS['add_related_doc'] = "https://airtable.com/shr9WRVEQpk8cEuSG/?prefill_Project=";
// to see open issues for a project
$GLOBALS['open_issues_base_folder'] = $base_url . "/projectopenissues/";

//// TEMPLATES ////
$GLOBALS['templates_base_folder'] = $base_url . "/templates/";
// link to open specific template in airtable for editing, uses Record_ID
$GLOBALS['templates_edit_link'] = "https://airtable.com/tblN4ml1RFKA5dEKZ/viw1U8bRWHzbg8yGf/";
// link to just edit rules and details
$GLOBALS['templates_rule_and_details_edit_link'] = "https://airtable.com/tblMjqo18EsRTCDFP/viwdxLmSRadBn62qZ/";

//// COMPONENTS ////
$GLOBALS['components_base_folder'] = $base_url . "/components/";
// link to open specific component in airtable for editing, uses Record_ID
$GLOBALS['components_edit_link'] = "https://airtable.com/tblYWtfeJcUcaW92U/viw8LSUoCBYaxOX1N/";
// Edit just parameters and details
$GLOBALS['components_parameters_and_details_edit_link'] = "https://airtable.com/tblYWtfeJcUcaW92U/viwX911NjwC30I7Lb/";

// edit a PLACED component
// Component to Component
$GLOBALS['placed_c_in_c_edit_link'] = "https://airtable.com/tblUQUA6r9AahQ73M/viwBqXLDj32N7byms/";
// Component to Template
$GLOBALS['placed_c_in_t_edit_link'] = "https://airtable.com/tblMjqo18EsRTCDFP/viwtTtzy0yUuJX4Yv/";


//// PORTFOLIOS ////
//view
$GLOBALS['portfolios_base_folder'] = $base_url . "/portfolios/";
//edit
$GLOBALS['portfolios_edit'] = "https://airtable.com/tblVGePToA39ns7mx/viw9EQXwZE74IaU52/";


//// ICONS ////
$GLOBALS['icon_edit'] = "<i class='fas fa-edit'></i>";
$GLOBALS['icon_edit_placement'] = "<i class='fas fa-object-group'></i>";
$GLOBALS['icon_add'] = "<i class='fas fa-plus-square'></i>";
$GLOBALS['icon_resolve'] = "<i class='fas fa-check-square'></i>";


$GLOBALS['icon_image'] = "<i class='fas fa-file-image'></i>";
$GLOBALS['icon_doc'] = "<i class='fas fa-file-alt'></i>";
