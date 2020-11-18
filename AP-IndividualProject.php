<?php  /* Template Name: Individual Project */ ?>

<? get_header(); ?>

<div id="main-content" class="main-content">

    <?php
    if (is_front_page() && twentyfourteen_has_featured_posts()) {
        // Include the featured content template.
        get_template_part('featured-content');
    }

    // Get Project from URL
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?  "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI'];
    $passed_project = array_slice(explode('/', $url), -2)[0];
    ?>

    <div id="primary" class="content-area">
        <div id="content" class="site-content" role="main">
            <article id="post-1" class="post-1 post type-post status-publish format-standard hentry category-uncategorized">

                <?php
                // Get Projects
                $query = new AirpressQuery("Projects", $GLOBALS['config_name']);
                $query->filterByFormula("{Slug}='$passed_project'");
                $projects = new AirpressCollection($query);

                // Get this project
                $this_project = $projects[0];

                // Get project name
                $project_name = $this_project["Project Name"];

                if (!empty($this_project["Confluence Link"])) {
                    $project_confluence = "<a target='_blank' href='" . $this_project["Confluence Link"] . "'>Confluence</a>";
                } else {
                    $project_confluence = "No Confluence link";
                }

                if (!empty($this_project["Figma Workspace"])) {
                    $project_figma = "<a target='_blank' href='" . $this_project["Figma Workspace"] . "'>Figma Workspace</a>";
                } else {
                    $project_figma = "No Figma workspace";
                }

                $links_area = $project_confluence . " | "
                    . $project_figma;

                $portfolio_card = return_project_card("yes", $GLOBALS['projects_base_folder'], "", $project_name, " ", " ", " ", " ", $links_area, "", "", "", "");
                ?>


                <header class="entry-header">
                    <?php

                    echo $portfolio_card;

                    ?>
                    <!-- .entry-meta -->
                </header><!-- .entry-header -->

                <div class="entry-content">


                    <?php

                    // Get all the epics within project
                    $query = new AirpressQuery("Epics", $GLOBALS['config_name']);
                    $query->filterByFormula("{Associated Projects}='$project_name'");
                    $query->sort("Epic Name", "asc");
                    $epics = new AirpressCollection($query);

                    // Create epics display
                    if (!is_airpress_empty($epics)) {
                        $num_templates = count($epics);

                        $epics_display = "<h2>" . $num_templates . " Epic(s) In Project</h2>";
                        foreach ($epics as $template) {
                            $view_link = $GLOBALS['epics_base_folder'] . $template["Slug"];
                            $T_Name = $template["Epic Name"];

                            $epics_display .= "<li><h4><a href='" . $view_link . "'>" . $T_Name . "</a></h4></li>";
                        }
                    } else {
                        echo "<p>There are no epics associated with this project</p>";
                    }

                    // Get all the templates used by project
                    $query = new AirpressQuery("Templates", $GLOBALS['config_name']);
                    $query->filterByFormula("{Associated Projects}='$project_name'");
                    $templates = new AirpressCollection($query);
                    $templates->populateRelatedField("Associated Epics", "Epics");

                    // Create templates display
                    if (!is_airpress_empty($templates)) {
                        $num_templates = count($templates);

                        $templates_display = "<h2>" . $num_templates . " Template(s) Used</h2>";
                        foreach ($templates as $template) {
                            $view_link = $GLOBALS['templates_base_folder'] . $template["Slug"];
                            $T_Name = $template["Template Name"];
                            $T_Epic = $template["Associated Epics"][0]["Epic Name"];

                            $templates_display .= "<li><h4><a href='" . $view_link . "'>" . $T_Name . "</a></h4></li><p>" . $T_Epic . "</p>";
                        }
                    } else {
                        echo "<p>There are no templates associated with this project</p>";
                    }

                    //// BUILD PAGE
                    echo "<ul>" . $epics_display . "</ul><p> </p><ol>$templates_display</ol>";
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
