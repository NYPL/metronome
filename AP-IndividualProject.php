<?php  /* Template Name: AP-IndividualProject */ ?>

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
    //Get Project from URL
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?  "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI'];
    $passed_project = array_slice(explode('/', $url), -2)[0];
    // note: passed project is not useful in queries, since names are case sensitive. Use "Slug" or "Project Name" from the query instead
    ?>

    <div id="primary" class="content-area">
        <div id="content" class="site-content" role="main">
            <article id="post-1" class="post-1 post type-post status-publish format-standard hentry category-uncategorized">


                <? 
//////// PROJECT QUERY
	$query=new AirpressQuery("Projects", $GLOBALS['config_name']);
	$query->filterByFormula("{Slug}='$passed_project'");
	$projects= new AirpressCollection($query);
	$projects->populateRelatedField("Project State","Project Status");
	$projects->populateRelatedField("Portfolio","Portfolios");
	// Get just this project
	$this_project=$projects[0];		
	$P_Record_ID=$projects[0]["Record ID"];
	// What's it's name?
	$this_project_name=$this_project["Project Name"];	
	$this_project_slug=$this_project["Slug"];	
?>

                <?php
                //////// DISPLAY PROJECT DETAILS
                if (!is_airpress_empty($projects)) {
                    foreach ($projects as $e) {
                        $card_wrap = "yes";
                        $base_folder = $GLOBALS['projects_base_folder'];
                        $slug = "na";
                        $project_name = $e["Project Name"];
                        $portfolio = $e["Portfolio"][0]["Name"];
                        $portfolio_slug = $e["Portfolio"][0]["Slug"];
                        $status = $e["Project State"][0]["Name"];
                        $launch_date = $e["Project Launch Date"];
                        $project_description = $e["Project Description"];
                        $jira_ticket = $e["Jira Ticket"];
                        $include_link = "no";
                        $include_edit = "yes";
                        $record_id = $e["Record ID"];
                        //set display
                        $portfolio_card = return_project_card($card_wrap, $base_folder, $slug, $project_name, $portfolio, $portfolio_slug, $status, $launch_date, $project_description, $jira_ticket, $include_link, $include_edit, $record_id);
                    }
                } else {
                    echo "no collection";
                }
                ?>


                <header class="entry-header">
                    <?php

                    echo $portfolio_card;

                    ?>
                    <!-- .entry-meta -->
                </header><!-- .entry-header -->

                <div class="entry-content">


                    <?php

                    //////// RELATED DOCS QUERY
                    /// Get docs from Related Materials 
                    // usage: AirPressQuery($tableName, CONFIG_ID or CONFIG_NAME)
                    $query = new AirpressQuery("Related Materials", $GLOBALS['config_name']);
                    $query->filterByFormula("{Project}='$this_project_name'");
                    $query->sort("Last Modified", "desc");
                    $related_docs = new AirpressCollection($query);


                    //////// DISPLAY RELATED DOCS
                    $num_docs = count($related_docs);

                    $related_docs_display = "<table>";
                    $related_docs_display .= "<tr><td><h2>" . $num_docs . " Related Doc(s)</h2></td><td style='text-align:right;'>";
                    $related_docs_display .= "<a href='" . $GLOBALS['add_related_doc'] . $this_project_name . "' target='new'>" . $GLOBALS['icon_add'] . "</a>";
                    $related_docs_display .= "</td></tr>";

                    if (!is_airpress_empty($related_docs)) {
                        foreach ($related_docs as $e) {
                            $d_name = $e["Name"];
                            $d_link = "";
                            $icon = "";
                            if (isset($e["Link"])) {
                                $d_link = $e["Link"];
                            } else {
                                $d_link = $e["Attachment URL"];
                            }


                            $d_link = "$icon <A href='" . $d_link . "' target='_new'>$d_name</a><br>";
                            $d_notes = $e["Notes"];
                            $d_time = $e["Last Modified"];
                            $d_time = trim_display_date($d_time); // a little sloppy
                            if (!empty($d_notes)) {
                            }
                            $related_docs_display .= "<tr><td colspan=2>" . $d_link . "<span class='not_so_important'> last updated: " . $d_time . "</span><br>" . $d_notes . "</td></tr>";
                        }
                        $related_docs_display .= "</table>";
                    } else {
                        //$related_docs_display.="No related docs. Add one";
                    }
                    $related_docs_display .= "</table>";
                    ?>



                    <?php

                    //////// SET UP TO DISPLAY BOTH TEMPLATES AND COMPONENTS
                    // Need list of templates to get related components
                    $All_Templates = "";


                    //////// TEMPLATES QUERY
                    /// Get templates from lookup table 
                    // usage: AirPressQuery($tableName, CONFIG_ID or CONFIG_NAME)
                    $query = new AirpressQuery("Templates to Projects LookUp", $GLOBALS['config_name']);
                    $query->filterByFormula("{Project}='$this_project_name'");
                    $query->sort("Template", "asc");
                    $templates = new AirpressCollection($query);
                    // connect related fields (Column, Table)
                    $templates->populateRelatedField("Template", "Templates");
                    // Breaks my brain
                    $templates->populateRelatedField("Template|IA", "UX Status");
                    $templates->populateRelatedField("Template|Design", "UX Status");
                    $templates->populateRelatedField("Template|Accessibility Status", "UX Status");
                    $templates->populateRelatedField("Template|Design Tech", "UX Status");

                    $T_base_edit_url = "https://airtable.com/tblN4ml1RFKA5dEKZ/viwXTL0bK4Oys5sJS/";

                    // Begining of hack, create array to hold componenets attached to a template
                    $all_components_raw = array();
                    ?>

                    <?php
                    //////// DISPLAY TEMPLATES
                    if (!is_airpress_empty($templates)) {
                        $num_templates = count($templates);

                        $templates_display = "<h2>" . $num_templates . " Template(s) Used</h2>";
                        // link to add or remove a template shoudl go here
                        $templates_display .= "<table>";
                        foreach ($templates as $e) {
                            $view_link = $GLOBALS['templates_base_folder'] . $e["Template"][0]["Slug"];
                            $T_Name = $e["Template"][0]["Template Name"];
                            $T_Record_ID = $e["Template"][0]["Record ID"];
                            $T_Description = $e["Template"][0]["Template Description"];

                            $IA_Status = $e["Template"][0]["IA"][0]["Name"];
                            $Design_Status = $e["Template"][0]["Design"][0]["Name"];
                            $Design_Tech_Status = $e["Template"][0]["Design Tech"][0]["Name"];
                            $Accessibility_Status = $e["Template"][0]["Accessibility Status"][0]["Name"];


                            //$T_Open_Issues=make_markdown($T_Open_Issues);

                            $T_Edit_Link = $T_base_edit_url . $T_Record_ID . "?blocks=hide";
                            $T_Edit_Link = "<a href='" . $T_Edit_Link . "' target='new'>" . $GLOBALS['icon_edit'] . "</a>";

                            //if(! empty($T_Open_Issues)){
                            //$T_Description.="<span class='urgent_message'>Open Issues: </span>".$T_Open_Issues;
                            //}

                            // Add this template to list of templates used in this project
                            $All_Templates .= $T_Name . " |";

                            $templates_display .= return_project_item_row($view_link, $T_Name, $IA_Status, $Design_Status, $Accessibility_Status, $Design_Tech_Status, $t_overall_status, $T_Edit_Link, $T_Description);




                            //Get My COMPONENTS
                            //$all_components_raw=array();
                            $query_for_components = new AirpressQuery("Component to Template LookUp", $GLOBALS['config_name']);
                            $filter_formula = "{Template}='$T_Name' ";
                            $query_for_components->filterByFormula($filter_formula);
                            //$query->filterByFormula($query);
                            $query_for_components->sort("Component", "asc");
                            $project_components = new AirpressCollection($query_for_components);
                            $project_components->populateRelatedField("Component", "Components");
                            $project_components->populateRelatedField("Component|IA", "UX Status");
                            $project_components->populateRelatedField("Component|Design", "UX Status");
                            $project_components->populateRelatedField("Component|Accessibility Status", "UX Status");
                            $project_components->populateRelatedField("Component|Design Tech", "UX Status");
                            $project_components->populateRelatedField("Component|Overall Status", "UX Status");

                            foreach ($project_components as $e) {
                                //what fields do I need
                                $C_Name = $e["Component"][0]["ComponentName"];
                                $IA_Status = $e["Component"][0]["IA"][0]["Name"];
                                $Design_Status = $e["Component"][0]["Design"][0]["Name"];
                                $Design_Tech_Status = $e["Component"][0]["Design Tech"][0]["Name"];
                                $Accessibility_Status = $e["Component"][0]["Accessibility Status"][0]["Name"];
                                $Overall_Status = $e["Component"][0]["Overall Status"][0]["Name"];
                                $C_Description = $e["Component"][0]["ComponentDescription"];
                                $C_T_Open_Issues = $e["Open Issues"];

                                $C_View_Link = $GLOBALS['components_base_folder'] . $e["Component"][0]["Slug"] . "/?fresh=true";

                                $C_Record_ID = $e["Component"][0]["Record ID"];
                                //FIX need to place variables in one place 
                                $base_edit_link = "https://airtable.com/tblYWtfeJcUcaW92U/viw8LSUoCBYaxOX1N/";

                                $C_Edit_Link = $base_edit_link . $C_Record_ID . "?blocks=hide";
                                $C_Edit_Link = "<a href='" . $C_Edit_Link . "'>" . $GLOBALS['icon_edit'] . "</a>";


                                $C_F_YN = $e["Component"][0]["Figma Link"];
                                // set note if figma link is missing
                                if (empty($C_F_YN)) {
                                    $C_Description .= "<span class='urgent_message'>no figma</span>";
                                }



                                // make a little array and dump it in
                                $temp_array = array(
                                    "name" => $C_Name,
                                    "ia" => $IA_Status,
                                    "des"   => $Design_Status,
                                    "ac"   => $Accessibility_Status,
                                    "dt"   => $Design_Tech_Status,
                                    "os"   => $Overall_Status,
                                    "descript"  => $C_Description,
                                    "oi"  => $C_T_Open_Issues,
                                    "link"  => $C_View_Link,
                                    "edit"  => $C_Edit_Link,
                                );
                                //if I don't already exist in larger array, add me
                                if (!array_key_exists($C_Name, $all_components_raw)) {
                                    $all_components_raw += array($C_Name => $temp_array);
                                }
                            }
                        }

                        $templates_display .= "</table>";
                    } else {
                        echo "There are no templates associated with this project";
                    }

                    // Ideally would use this to buidl a simpler query and avoid the new array echo "All_Templates ".$All_Templates;


                    //////// DISPLAY COMPONENTS
                    $U_Num_Components = count($all_components_raw);
                    sort($all_components_raw);
                    $component_display .= "<h2>" . $U_Num_Components . " Component(s) Used</h2>";
                    // FIX put in handling where there are no components etc
                    $component_display .= "<table>";
                    foreach ($all_components_raw as $e) {
                        $C_Name = $e["name"];


                        $component_display .= return_project_item_row($e["link"], $e["name"], $e["ia"], $e["des"], $e["ac"], $e["dt"], $e["os"], $e["edit"], $e["descript"]);
                    }
                    $component_display .= "</table>";

                    //// LINK TO OPEN ISSUES PAGE
                    $link_to_oi = $GLOBALS['open_issues_base_folder'] . $this_project_slug;
                    $link_to_oi = "<a href='$link_to_oi'>View all Open Issues for this project</a>";
                    //// BUILD PAGE
                    echo "<table><tr><td colspan=3><strong>$link_to_oi</strong><br><br><br></td></tr><tr><td width='65%'>$templates_display $component_display</td><td width=5%>&nbsp;</td><td width='30%'>$related_docs_display</td></tr></table>";
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
