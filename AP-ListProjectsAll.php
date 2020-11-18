<?php /* Template Name: Projects */ ?>

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
                    <h1 class="entry-title">Projects</h1>
                    <!-- .entry-meta -->
                </header><!-- .entry-header -->

                <div class="entry-content">

                    <?php

                    // Get all of our projects
                    $query = new AirpressQuery("Projects", $GLOBALS['config_name']);
                    $query->sort("Project Name", "asc");
                    $projects = new AirpressCollection($query);
                    $projects->populateRelatedField("Project State", "Project Status");
                    $projects->populateRelatedField("Portfolio", "Portfolios");

                    if (!is_airpress_empty($projects)) {

                        foreach ($projects as $e) {

                            $base_folder = $GLOBALS['projects_base_folder'];

                            $card_wrap = "yes";
                            $slug = $e["Slug"];
                            $project_name = $e["Project Name"];
                            $portfolio = $e["Portfolio"][0]["Name"];
                            $portfolio_slug = $e["Portfolio"][0]["Slug"];
                            $status = " ";
                            $launch_date = " ";
                            $project_confluence = $e["Confluence Link"];
                            $project_figma = $e["Figma Workspace"];
                            $project_description = $e["Project Description"];
                            $jira_ticket = $e["Jira Ticket"];

                            $include_link = "yes";
                            $include_edit = "no";
                            $record_id = "";

                            if (!empty($project_confluence)) {
                                $project_confluence = "<a target='_blank' href='" . $e["Confluence Link"] . "'>Confluence</a>";
                            } else {
                                $project_confluence = "No Confluence link";
                            }

                            if (!empty($project_figma)) {
                                $project_figma = "<a target='_blank' href='" . $e["Figma Workspace"] . "'>Figma Workspace</a>";
                            } else {
                                $project_figma = "No Figma workspace";
                            }

                            $links_area = $project_confluence . " | "
                                . $project_figma;

                            //set display
                            $portfolio_card = return_project_card($card_wrap, $base_folder, $slug, $project_name, $portfolio, $portfolio_slug, $status, $launch_date, $links_area, $include_link, $include_edit, $record_id);

                            $projects_in_notset .= $portfolio_card;
                        }
                    } else {
                        echo "no collection";
                    }

                    echo $projects_in_notset;
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
