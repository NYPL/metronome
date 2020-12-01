<?php /* Template Name: Individual Template */ ?>

<? get_header(); ?>

<div id="main-content" class="main-content">

    <?php
    if (is_front_page() && twentyfourteen_has_featured_posts()) {
        // Include the featured content template.
        get_template_part('featured-content');
    }
    ?>


    <?php
    //////// VARIABLES
    // Config
    define("CONFIG_ID", 0);
    define("CONFIG_NAME", "NYPLdoc2");
    // Templates folder link
    $base_folder_link = "/components/";
    // Link to MVP edit form
    $base_edit_link = "https://airtable.com/tblN4ml1RFKA5dEKZ/viwXTL0bK4Oys5sJS/";
    //Get Template Slug from URL
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?  "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI'];
    $passed_template = array_slice(explode('/', $url), -2)[0];

    ?>

    <?php

    //////// GET TEMPLATE DETAILS
    // usage: AirPressQuery($tableName, CONFIG_ID or CONFIG_NAME)
    $query = new AirpressQuery("Templates", CONFIG_NAME);
    $query->filterByFormula("{Slug}='$passed_template'");
    $templates = new AirpressCollection($query);
    $templates->populateRelatedField("Associated Projects", "Projects");
    $templates->populateRelatedField("Associated Epics", "Epics");

    $T_Record_ID = $templates[0]["Record ID"];

    ?>

    <div id="primary" class="content-area">
        <div id="content" class="site-content" role="main">
            <article id="post-1" class="post-1 post type-post status-publish format-standard hentry category-uncategorized">

                <header class="entry-header">
                    <?php

                    $simple = $templates[0];

                    $t_title = $simple["Template Name"];
                    $t_record_id = $simple["Record ID"];

                    $T_Figma_Link = $simple["Figma Link"];
                    $T_Projects = $simple["Associated Projects"][0]["Project Name"];
                    $T_Project_slug = $simple["Associated Projects"][0]["Slug"];
                    $T_Epics = $simple["Associated Epics"][0]["Epic Name"];
                    $T_Epic_slug = $simple["Associated Epics"][0]["Slug"];
                    $T_version = $simple["Version"];
                    $T_changelog = $simple["CHANGELOG"];


                    $t_project_string = "Associated Project: <a href='" .
                        $GLOBALS['projects_base_folder'] .
                        $T_Project_slug .
                        "'>" . $T_Projects . "</a>";

                    $t_epic_string = "<br>Associated Epic: <a href='" . $GLOBALS['epics_base_folder'] .
                        $T_Epic_slug . "'>" .
                        $T_Epics . "</a>";

                    $t_description =
                        "<strong>" . $simple["Slug"] .
                        ", Version: " . $T_version . "</strong><br>" .
                        $simple["Template Description"] . "<p class='aslkdjfkd'>" .
                        $t_project_string .
                        $t_epic_string .
                        "</p>";


                    /// Links to code
                    $not_available = "N/A";

                    $T_Twig_Code = "Code " . $not_available;
                    $T_Twig_Storybook = "Patternlab " . $not_available;
                    $T_React_Code = "Code " . $not_available;
                    $T_React_Storybook = "Storybook " . $not_available;
                    $T_Jira_Link = "";

                    $temp_header = return_display_item_header("Template", $t_title, $t_record_id, $t_description, $T_React_Storybook, $T_React_Code, $T_Twig_Storybook, $T_Twig_Code,  $C_Primary_Func_Specs, $T_Primary_Accessibility, $these_parameters, $T_Figma_Link);


                    echo $temp_header;


                    ?>
                    <!-- .entry-meta -->
                </header><!-- .entry-header -->

                <div class="entry-content">

                    <?php

                    //////// DISPLAY TEMPLATE DETAILS

                    // We need $T_Name for later, a little sloppy
                    $T_Name = "";
                    // same
                    $T_Open_Issues_Resolved = "";
                    // same
                    $T_Accessibility_Notes = "not set";


                    if (!is_airpress_empty($templates)) {


                        foreach ($templates as $e) {
                            $T_Name = $e["Template Name"];

                            //////// GET OPEN ISSUES FOR Template
                            $query_oi = new AirpressQuery("Open Issues", CONFIG_NAME);
                            $query_oi->filterByFormula("{Template Name}='$T_Name'");
                            // why can't  make AND {Resolved}!='1' work?
                            // AND {Resolved}!=TRUE()
                            $query_oi->sort("Date Created", "asc");
                            $T_Open_Issues = new AirpressCollection($query_oi);

                            // display accessibility notes	

                            $T_Accessibility_Notes = make_markdown($e["Accessibility"]);
                            echo "<br><span class='section_header'>Accessibility</span>" . $T_Accessibility_Notes;

                            echo "<br><strong>CHANGELOG:<br>" . make_markdown($T_changelog);
                        }
                    } else {
                        echo "Template not found";
                    }

                    //////// GET COMPONENTS 
                    /// Get component from lookup table 
                    // usage: AirPressQuery($tableName, CONFIG_ID or CONFIG_NAME)
                    $query = new AirpressQuery("Template Placement Requirements", CONFIG_NAME);
                    $query->filterByFormula("{Template}='$T_Name'");
                    $query->sort("Order", "asc");
                    $components = new AirpressCollection($query);
                    // connect related fields (Column, Table)
                    $components->populateRelatedField("Placed Component", "Components");
                    // Breaks my brain
                    $components->populateRelatedField("Component|IA", "UX Status");
                    $components->populateRelatedField("Component|Design", "UX Status");
                    $components->populateRelatedField("Component|Design Tech", "UX Status");
                    $components->populateRelatedField("Component|Accessibility Status", "UX Status");
                    $components->populateRelatedField("Component|Overall Status", "UX Status");

                    // Header for Components
                    $Num_Components = count($components);
                    $add_a_component_link = "<a href='https://airtable.com/shrUc3dtBvnhfavnN?prefill_Template=" . $T_Name . "' target=new>" . $GLOBALS['icon_add'] . "</a>";
                    echo "<h3>" . $Num_Components . " Component(s) Used " . $add_a_component_link . "</h3>";


                    $base_folder_link = "/components/";
                    $base_edit_link = "https://airtable.com/tblYWtfeJcUcaW92U/viw8LSUoCBYaxOX1N/";

                    //////// DISPLAY COMPONENTS 
                    echo "<table class='cleantable'>";
                    foreach ($components as $e) {

                        $number = $e["Order"];
                        $C_Description = $e["Placed Component"][0]["Component Description"];
                        $C_Accessibility = $e["Placed Component"][0]["Accessibility Details"];
                        $C_Func_Specs = $e["Placed Component"][0]["Functional Specs"];


                        //Note this is the connection between the template and the componenet, not the Record ID for the component itself which is set and used later
                        $C_to_T_Record_ID = $e["Record ID"];
                        $C_Record_ID = $e["Placed Component"][0]["Record ID"];
                        $number = $e["Order"];
                        $C_Manual_or_Auto = return_page_placement_type("Auto");

                        $C_Placement_Des = $e["Placement Description"];
                        $Page_Rules = $e["Page Rules & Details"];


                        $IA_Status = $e["Placed Component"][0]["IA"][0]["Name"];
                        $Design_Status = $e["Placed Component"][0]["Design"][0]["Name"];
                        $Design_Tech_Status = $e["Placed Component"][0]["Design Tech"][0]["Name"];
                        $Accessibility_Status = $e["Placed Component"][0]["Accessibility Status"][0]["Name"];
                        $Overall_Status = $e["Placed Component"][0]["Overall Status"][0]["Name"];

                        $C_Name = $e["Placed Component"][0]["Component Name"];
                        $C_Slug = $e["Placed Component"][0]["Slug"];

                        $C_Description = $e["Placed Component"][0]["Component Description"];
                        $C_Accessibility = $e["Placed Component"][0]["Accessibility Details"];
                        $C_Func_Specs = $e["Placed Component"][0]["Functional Specs"];

                        $these_parameters = return_my_parameters($e["Placed Component"][0]);
                        $optional = $e["Optional or Required"];

                        $test = return_placed_component_details("Template", $C_to_T_Record_ID, $C_Record_ID, $number, $C_Manual_or_Auto, $C_Placement_Des, $Page_Rules, $C_Name, $C_Slug, $C_Description, $C_Accessibility, $C_Func_Specs, $these_parameters, $optional);

                        echo $test;
                    }
                    echo "</table>";

                    // NOTES ON USAGE
                    echo "<hr>";
                    echo "<span class='themsthebreaks'>" . $T_Used_In_Projects . "</span>";

                    ?>


                </div>
            </article>
        </div><!-- #content -->
    </div><!-- #primary -->
    <?php get_sidebar('content'); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
