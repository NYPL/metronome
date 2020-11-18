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
                    <h1 class="entry-title">All Components</h1>
                    <!-- .entry-meta -->
                </header><!-- .entry-header -->

                <div class="entry-content">



                    <!-- Displaying list ofall components -->
                    <?php


                    $query = new AirpressQuery();
                    $query->setConfig($GLOBALS['config_name']);
                    $query->table("Components")->view("All Components");
                    $query->sort("Component Name", "asc");
                    //$query->sort("ComponentName","asc");
                    $components = new AirpressCollection($query);
                    $components->populateRelatedField("IA", "UX Status");
                    $components->populateRelatedField("Design", "UX Status");
                    $components->populateRelatedField("Design Technology", "UX Status");
                    $components->populateRelatedField("Accessibility Status", "UX Status");
                    $components->populateRelatedField("Overall Status", "UX Status");

                    if (!is_airpress_empty($components)) {

                        // Set up dividers for groups
                        $New_Components = "<tr><td colspan=2 ><h3>New Components</h3><hr></td></tr>";
                        $Old_Components = "<tr><td colspan=2 ><h3>Old Components</h3><hr></td></tr>";

                        $num_components = count($components);
                        echo "<h2>" . $num_components . " Component(s)</h2>";

                        echo "<table>";

                        $components_display = "";
                        foreach ($components as $e) {

                            //status
                            $IA_Status = $e["IA"][0]["Name"];
                            $Design_Status = $e["Design"][0]["Name"];
                            $Design_Tech_Status = $e["Design Technology"][0]["Name"];
                            $Accessibility_Status = $e["Accessibility Status"][0]["Name"];
                            $Overall_Status = $e["Overall Status"][0]["Name"];
                            //description
                            $C_Description = $e["Component Description"];
                            //base type
                            $C_Base_Type = $e["Base Type"];
                            //links
                            $C_View_Link = $GLOBALS['components_base_folder'] . $e["Slug"] . "/?fresh=true'";
                            $C_Record_ID = $e["Record ID"];
                            $C_Edit_Link = $GLOBALS['components_edit_link'] . $C_Record_ID . "?blocks=hide";
                            $C_Edit_Link = "<a href='" . $C_Edit_Link . "' target='new'>" . $GLOBALS['icon_edit'] . "</a>";

                            //print $C_Base_Type." | ".$e["ComponentName"]."<hr>";

                            // Grouping by type
                            $temp_row = return_project_item_row($C_View_Link, $e["Component Name"], $IA_Status, $Design_Status, $Accessibility_Status, $Design_Tech_Status, $Overall_Status, $C_Edit_Link, $C_Description);


                            if ($e["Deprecated"] == "False") {
                                $New_Components .= $temp_row;
                            } else {
                                $Old_Components .= $temp_row;
                            }
                        }

                        echo $New_Components;
                        echo $Old_Components;

                        echo "</table>";
                    }
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
