<?php /* Template Name: AP-ListComponentsAll */ ?>

<? get_header(); ?>

<div id="main-content" class="main-content">

    <?php
    if (is_front_page() && twentyfourteen_has_featured_posts()) {
        // Include the featured content template.
        get_template_part('featured-content');
    }
    ?>
    <div id="primary" class="content-area">
        <div id="content" class="site-content" role="main">
            <article id="post-1" class="post-1 post type-post status-publish format-standard hentry category-uncategorized">

                <header class="entry-header">
                    <h1 class="entry-title">Reno Overview</h1>
                    <!-- .entry-meta -->
                </header><!-- .entry-header -->

                <div class="entry-content">



                    <!-- Displaying list ofall projects -->
                    <?php

                    $base_edit_link = "https://airtable.com/tblYWtfeJcUcaW92U/viw8LSUoCBYaxOX1N/";

                    $query = new AirpressQuery();
                    $query->setConfig("NYPLdoc1");
                    $query->table("Components");
                    $query->sort("ComponentName", "asc");
                    $components = new AirpressCollection($query);
                    $components->populateRelatedField("IA", "UX Status");
                    $components->populateRelatedField("Design", "UX Status");
                    $components->populateRelatedField("Design Tech", "UX Status");

                    // create array of all components
                    $master_list_components = array();


                    if (!is_airpress_empty($components)) {


                        foreach ($components as $e) {

                            // add to master list
                            $master_list_components[] = $e["ComponentName"];
                        }
                    }


                    // get list of projects with RENO
                    $query_projects = new AirpressQuery();
                    $query_projects->setConfig("NYPLdoc1");
                    $query_projects->table("Projects");
                    $query_projects->sort("Project Name", "asc");
                    $all_projects = new AirpressCollection($query_projects);

                    $Projects_components = array();

                    // start table
                    $overviewtable = "<table style='border: 1px solid black;'><tr>";
                    $overviewtable .= "<td>---</td>";
                    foreach ($all_projects as $p) {

                        $all_components_raw = array();

                        $p_name = $p['Project Name'];
                        $pos = stripos($p_name, 'reno');

                        if ($pos !== false) {
                            // get my templates and componenets
                            $query_templates = new AirpressQuery("Templates to Projects LookUp", CONFIG_NAME);
                            $query_templates->filterByFormula("{Project}='$p_name'");
                            $query_templates->sort("Template", "asc");
                            $templates = new AirpressCollection($query_templates);
                            // connect related fields (Column, Table)
                            $templates->populateRelatedField("Template", "Templates");

                            // Begining of hack, create array to hold componenets attached to a template
                            $all_components_raw = array();

                            $overviewtable .= "<td><strong>$p_name</strong>";

                            foreach ($templates as $e) {
                                $T_Name = $e["Template"][0]["Template Name"];
                                $overviewtable .= "<br>" . $T_Name;

                                //Get My COMPONENTS
                                $query_for_components = new AirpressQuery("Component to Template LookUp", CONFIG_NAME);
                                $filter_formula = "{Template}='$T_Name' ";
                                $query_for_components->filterByFormula($filter_formula);
                                //$query->filterByFormula($query);
                                $query_for_components->sort("Component", "asc");
                                $project_components = new AirpressCollection($query_for_components);
                                $project_components->populateRelatedField("Component", "Components");
                                $project_components->populateRelatedField("Component|IA", "UX Status");
                                $project_components->populateRelatedField("Component|Design", "UX Status");
                                $project_components->populateRelatedField("Component|Design Tech", "UX Status");

                                foreach ($project_components as $e) {
                                    $C_Name = $e["Component"][0]["ComponentName"];
                                    $all_components_raw[] = $C_Name;
                                }
                            }
                            // test if componenets are added
                            // make a little array and dump it in
                            $temp_array = array(
                                "name" => $p_name,
                                "components" => $all_components_raw,
                            );
                            $Projects_components[] = array($temp_array);
                            $overviewtable .= "</td>";
                        }
                    }

                    // end table

                    //foreach($Projects_components as $pc){
                    //	$p_Name=$pc[0]['name'];
                    //echo $p_Name;
                    //		$p_components=$pc[0]['components'];
                    //echo $p_components."<hr>";
                    //	}

                    //for each component, am I in the lsit?
                    foreach ($master_list_components as $mc) {
                        $overviewtable .= "<tr><td>NAME $mc</td>";
                        // am I in this list?
                        foreach ($Projects_components as $pc) {
                            $p_components = $pc[0]['components'];
                            $note = "";
                            if (in_array($mc, $p_components)) {
                                $note = "yes";
                            } else {
                                $note = "no";
                            }
                            $overviewtable .= "<td> $note</td>";
                        }
                        $overviewtable .= "</tr>";
                    }


                    $overviewtable .= "</tr></table>";

                    echo "<hr>" . $overviewtable;
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
