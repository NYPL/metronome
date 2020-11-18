<?php /* Template Name: Epics */ ?>

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
                    <h1 class="entry-title">Epics</h1>
                    <!-- .entry-meta -->
                </header><!-- .entry-header -->

                <div class="entry-content">

                    <?php

                    // Get our epics
                    $query = new AirpressQuery("Epics", $GLOBALS['config_name']);
                    $query->sort("Associated Projects", "asc");
                    $epics = new AirpressCollection($query);
                    $epics->populateRelatedField("Associated Projects", "Projects");

                    if (!is_airpress_empty($epics)) {

                        foreach ($epics as $e) {

                            $base_folder = $GLOBALS['epics_base_folder'];

                            $card_wrap = "yes";
                            $slug = $e["Slug"];
                            $epic_name = $e["Epic Name"];
                            $portfolio = $e["Portfolio"][0]["Name"];
                            $portfolio_slug = $e["Portfolio"][0]["Slug"];

                            $associated_project = $e["Associated Projects"][0]["Project Name"];
                            // Get the project slug
                            $epic_project_slug = $epic["Associated Projects"][0]["Slug"];
                            $project_url = $GLOBALS['projects_base_folder'] . $epic_project_slug;

                            $project_link = "<a href='" . $project_url . "'>" . $associated_project . "</a>";

                            $project_description = $e["Project Description"];
                            $jira_ticket = $e["Jira Ticket"];

                            $include_link = "yes";
                            $include_edit = "no";
                            $record_id = "";
                            //set display
                            $epic_card = return_project_card($card_wrap, $base_folder, $slug, $epic_name, $portfolio, $portfolio_slug, " ", " ", $project_link, $include_link, $include_edit, $record_id);

                            $epics_in_notset .= $epic_card;
                        }
                    } else {
                        echo "no collection";
                    }

                    echo $epics_in_notset;

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
