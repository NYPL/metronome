<?php /* Template Name: AP-IndividualPortfolio */ ?>

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
    define("CONFIG_NAME", "NYPLdoc1");
    // Templates folder link
    $base_folder_link = $GLOBALS['portfolios_base_folder'];

    // Link to MVP edit form
    $base_edit_link = $GLOBALS['portfolios_edit'];

    //Get Portfolio Slug from URL
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?  "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI'];
    $passed_portfolio = array_slice(explode('/', $url), -2)[0];

    ?>


    <?php

    //////// GET PORTFOLIO DETAILS
    // usage: AirPressQuery($tableName, CONFIG_ID or CONFIG_NAME)
    $query = new AirpressQuery("Portfolios", CONFIG_NAME);
    $query->filterByFormula("{Slug}='$passed_portfolio'");
    $portfolios = new AirpressCollection($query);
    //$portfolios->populateRelatedField("Project State","Project Status");
    //$portfolios->populateRelatedField("Portfolio","Portfolios");
    $P_Record_ID = $portfolios[0]["Record ID"];
    $P_Name = $portfolios[0]["Name"];

    ?>
    <div id="primary" class="content-area">
        <div id="content" class="site-content" role="main">
            <article id="post-1" class="post-1 post type-post status-publish format-standard hentry category-uncategorized">

                <header class="entry-header">
                    <?php
                    $temp_title = $portfolios[0]["Name"];
                    $temp_edit_Link = "<a href='" . $base_edit_link . $P_Record_ID . "?blocks=hide' target='new'>" . $GLOBALS['icon_edit'] . "</a>";
                    $temp_header = return_display_header($temp_title, $temp_edit_Link);
                    echo $temp_header
                    ?>
                    <!-- .entry-meta -->
                </header><!-- .entry-header -->

                <div class="entry-content">

                    <?php
                    //////// DISPLAY PORTFOLIO DETAILS

                    if (!is_airpress_empty($portfolios)) {
                        foreach ($portfolios as $e) {
                            $P_Prefix = $e["Prefix"];
                            $P_Name = $e["Name"];
                            $P_Slug = $e["Slug"];
                            $P_Description = $e["Description"];
                            $P_Areas_Covered = $e["Areas Covered"];
                            $P_Lead = $e["Lead"];
                            $P_Product_Lead = $e["Product_Lead"];
                            $P_Tech_Lead = $e["Tech Lead"];
                            $P_UX_Lead = $e["UX Lead"];

                            $card_wrap = "no";
                            $include_link = "no";
                            $base_folder = "na";
                            $slug = "na";

                            $portfolio_card = return_portfolio_card($card_wrap, $include_link, $base_folder, $slug, $P_Prefix, $P_Name, $P_Description, $P_Areas_Covered, $P_Lead, $P_Product_Lead, $P_Tech_Lead, $P_UX_Lead);
                            echo $portfolio_card;
                        }
                    } else {
                        echo "no collection";
                    }
                    ////////// GET PROJECTS
                    ////////// This is list all projects filtered by this portfolio
                    // usage: AirPressQuery($tableName, CONFIG_ID or CONFIG_NAME)
                    $query = new AirpressQuery("Projects", CONFIG_NAME);
                    $query->filterByFormula("{Portfolio}='$P_Name'");
                    $query->sort("Project Name", "asc");
                    $projects = new AirpressCollection($query);
                    // connect related fields (Column, Table)
                    $projects->populateRelatedField("Project State", "Project Status");
                    $projects->populateRelatedField("Portfolio", "Portfolios");



                    // Set variables per category
                    $projects_in_exploration = "";
                    $projects_in_progress = "";
                    $projects_in_definition = "";
                    $projects_in_notstarted = "";
                    $projects_in_notset = "";
                    $projects_in_complete = "";
                    $projects_in_blocked = "";
                    $projects_in_paused = "";
                    $projects_in_canceled = "";

                    ////////// DISPLAY PROJECTS
                    if (!is_airpress_empty($projects)) {
                        foreach ($projects as $e) {

                            $card_wrap = "yes";
                            $base_folder = $GLOBALS['projects_base_folder'];
                            $slug = $e["Slug"];
                            $project_name = $e["Project Name"];
                            $portfolio = $e["Portfolio"][0]["Name"];
                            $portfolio_slug = "a";
                            $status = $e["Project State"][0]["Name"];
                            $launch_date = $e["Project Launch Date"];
                            $project_description = $e["Project Description"];
                            $jira_ticket = $e["Jira Ticket"];

                            $include_link = "yes";
                            $include_edit = "yes";
                            $record_id = $e["Record ID"];
                            //set display
                            $project_card = return_project_card($card_wrap, $base_folder, $slug, $project_name, $portfolio, $portfolio_slug, $status, $launch_date, $project_description, $jira_ticket, $include_link, $include_edit, $record_id);


                            // assign to variable by category
                            switch ($status) {
                                case "In Progress":
                                    $projects_in_progress .= $project_card;
                                    break;
                                case "Definition":
                                    $projects_in_definition .= $project_card;
                                    break;
                                case "Exploration":
                                    $projects_in_exploration .= $project_card;
                                    break;
                                case "Blocked":
                                    $projects_in_blocked .= $project_card;
                                    break;
                                case "Paused":
                                    $projects_in_paused .= $project_card;
                                    break;
                                case "Not Started":
                                    $projects_in_notstarted .= $project_card;
                                    break;
                                case "Not Set":
                                    $projects_in_notset .= $project_card;
                                    break;
                                case "":
                                    $projects_in_notset .= $project_card;
                                    break;
                                case "Complete":
                                    $projects_in_complete .= $project_card;
                                    break;
                                case "Canceled":
                                    $projects_in_canceled .= $project_card;
                                    break;
                            }
                        }
                    } else {
                        echo "no collection";
                    }
                    echo display_this_project_group("In Progress", $projects_in_progress);

                    echo display_this_project_group("Definition", $projects_in_definition);

                    echo display_this_project_group("Exploration", $projects_in_exploration);

                    echo display_this_project_group("Not Started", $projects_in_notstarted);

                    echo display_this_project_group("Not Set", $projects_in_notset);

                    echo display_this_project_group("Blocked", $projects_in_blocked);

                    echo display_this_project_group("Paused", $projects_in_paused);

                    echo display_this_project_group("Complete", $projects_in_complete);

                    echo display_this_project_group("Canceled", $projects_in_canceled);
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
