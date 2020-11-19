<?php  /* Template Name: Individual Epic */ ?>

<? get_header(); ?>

<div id="main-content" class="main-content">

    <?php
    if (is_front_page() && twentyfourteen_has_featured_posts()) {
        // Include the featured content template.
        get_template_part('featured-content');
    }

    // While not ideal, I can't effect file names, so this file has been repurposed for EPICS.
    // Get Epic from URL
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?  "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI'];
    $passed_project = array_slice(explode('/', $url), -2)[0];
    ?>

    <div id="primary" class="content-area">
        <div id="content" class="site-content" role="main">
            <article id="post-1" class="post-1 post type-post status-publish format-standard hentry category-uncategorized">

                <?php
                // Get Epics
                $query = new AirpressQuery("Epics", $GLOBALS['config_name']);
                $query->filterByFormula("{Slug}='$passed_project'");
                $epics = new AirpressCollection($query);
                $epics->populateRelatedField("Associated Projects", "Projects");

                // Get this epic
                $epic = $epics[0];

                // Get Epic information
                $epic_name = $epic["Epic Name"];
                $epic_confluence_link = $epic["Confluence Link"];
                $epic_project = $epic["Associated Projects"][0]["Project Name"];

                // Get the project slug
                $epic_project_slug = $epic["Associated Projects"][0]["Slug"];
                $project_url = $GLOBALS['projects_base_folder'] . $epic_project_slug;

                $links_area = "
                    <a href='" . $project_url . "'>Project: " .
                    $epic_project .
                    "</a> | <a target='_blank' href='"
                    . $epic_confluence_link .
                    "'>Confluence</a>";

                $epic_card = return_project_card("yes", $GLOBALS['epics_base_folder'], "", $epic_name, "", "", " ", " ", $links_area, "", "", "", "");
                ?>


                <header class="entry-header">
                    <?php
                    echo $epic_card;
                    ?>

                    <div class="entry-content">

                        <?php

                        // Get Templates
                        $query = new AirpressQuery("Templates", $GLOBALS['config_name']);
                        $query->filterByFormula("{Associated Epics}='$epic_name'");
                        $templates = new AirpressCollection($query);
                        $raw_components;

                        // Build list items
                        if (!is_airpress_empty($templates)) {
                            $num_templates = count($templates);

                            $templates_header = "<h2>" . $num_templates . " Template(s) Used</h2>";
                            $templates_list = "";

                            foreach ($templates as $template) {
                                $view_link = $GLOBALS['templates_base_folder'] . $template["Slug"];
                                $template_name = $template["Template Name"];
                                $templates_list .= "<li><h4><a href='" . $view_link . "'>" . $template_name . "</a></h4></li>";
                            }
                        } else {
                            echo "There are no templates associated with this project";
                        }

                        // Get components
                        $component_query = new AirpressQuery("Template Placement Requirements", $GLOBALS['config_name']);
                        $component_query->filterByFormula("{Associated Epic}='$epic_name'");
                        $component_collection = new AirpressCollection($component_query);
                        $component_collection->populateRelatedField("Placed Component", "Components");

                        $all_components_raw = array();

                        foreach ($component_collection as $component) {
                            if (!empty($component["Placed Component"][0]["Component Name"])) {
                                $component_name = $component["Placed Component"][0]["Component Name"];
                                $component_slug = $component["Placed Component"][0]["Slug"];
                                $component_link = $GLOBALS['components_base_folder'] . $component_slug;
                                $temp_component = array(
                                    "name" => $component_name,
                                    "link" => $component_link
                                );
                                // If I don't already exist in larger array, add me
                                if (!array_key_exists($component_name, $all_components_raw)) {
                                    $all_components_raw += array($component_name => $temp_component);
                                }
                            }
                        }

                        sort($all_components_raw);
                        $components_list = "";
                        foreach ($all_components_raw as $component => $val) {
                            $components_list .= "<li><h4><a href='" . $val["link"] . "'>" . $val["name"] . "</a></h4></li>";
                        }

                        // Create page
                        echo $templates_header . "<ol>$templates_list</ol><h2>" . count($all_components_raw) . " Components Used</h2><ul>" . $components_list . "</ul>";
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
?>
