<?php /* Template Name: AP-ListPortfoliosAll */ ?>

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
                    <h1 class="entry-title">Portfolios</h1>
                    <!-- .entry-meta -->
                </header><!-- .entry-header -->

                <div class="entry-content">



                    <!-- Displaying list ofall projects -->
                    <?php
                    define("CONFIG_ID", 0);
                    define("CONFIG_NAME", "NYPLdoc1");

                    // usage: AirPressQuery($tableName, CONFIG_ID or CONFIG_NAME)
                    $query = new AirpressQuery("Portfolios", CONFIG_NAME);
                    $query->sort("Name", "asc");
                    $portfolios = new AirpressCollection($query);


                    // Portfolios folder link
                    $base_folder_link = $GLOBALS['portfolios_base_folder'];

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



                            $card_wrap = "yes";
                            $include_link = "yes";


                            $portfolio_card = return_portfolio_card($card_wrap, $include_link, $base_folder_link, $P_Slug, $P_Prefix, $P_Name, $P_Description, $P_Areas_Covered, $P_Lead, $P_Product_Lead, $P_Tech_Lead, $P_UX_Lead);
                            echo $portfolio_card;
                        }
                    } else {
                        echo "no collection";
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
