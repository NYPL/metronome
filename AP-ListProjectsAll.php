<?php /* Template Name: AP-ListProjectsAll */ ?>

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
                    <h1 class="entry-title">All Projects</h1>
                    <!-- .entry-meta -->
                </header><!-- .entry-header -->

                <div class="entry-content">




                    <?php

                    ////// Displaying list of all projects //////
                    $query = new AirpressQuery("Projects", $GLOBALS['config_name']);
                    $query->sort("Project Name", "asc");
                    $projects = new AirpressCollection($query);
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

                    if (!is_airpress_empty($projects)) {

                        foreach ($projects as $e) {

                            $base_folder = $GLOBALS['projects_base_folder'];

                            $card_wrap = "yes";
                            $slug = $e["Slug"];
                            $project_name = $e["Project Name"];
                            $portfolio = $e["Portfolio"][0]["Name"];
                            $portfolio_slug = $e["Portfolio"][0]["Slug"];
                            $status = $e["Project State"][0]["Name"];
                            $launch_date = $e["Project Launch Date"];
                            $project_description = $e["Project Description"];
                            $jira_ticket = $e["Jira Ticket"];

                            $include_link = "yes";
                            $include_edit = "no";
                            $record_id = "";
                            //set display
                            $portfolio_card = return_project_card($card_wrap, $base_folder, $slug, $project_name, $portfolio, $portfolio_slug, $status, $launch_date, $project_description, $jira_ticket, $include_link, $include_edit, $record_id);


                            // assign to variable by category
                            switch ($status) {
                                case "In Progress":
                                    $projects_in_progress .= $portfolio_card;
                                    break;
                                case "Definition":
                                    $projects_in_definition .= $portfolio_card;
                                    break;
                                case "Exploration":
                                    $projects_in_exploration .= $portfolio_card;
                                    break;
                                case "Blocked":
                                    $projects_in_blocked .= $portfolio_card;
                                    break;
                                case "Paused":
                                    $projects_in_paused .= $portfolio_card;
                                    break;
                                case "Not Started":
                                    $projects_in_notstarted .= $portfolio_card;
                                    break;
                                case "Not Set":
                                    $projects_in_notset .= $portfolio_card;
                                    break;
                                case "":
                                    $projects_in_notset .= $portfolio_card;
                                    break;
                                case "Complete":
                                    $projects_in_complete .= $portfolio_card;
                                    break;
                                case "Canceled":
                                    $projects_in_canceled .= $portfolio_card;
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
