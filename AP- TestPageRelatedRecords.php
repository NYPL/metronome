<?php /* Template Name: AP-TestPageRelatedRecords */ ?>

<? get_header(); ?>

<div id="main-content" class="main-content">

<?php
if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
	// Include the featured content template.
	get_template_part( 'featured-content' );
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
			
			

<?php 
define("CONFIG_ID", 1);
define("CONFIG_NAME", "TestConnection");

	
// usage: AirPressQuery($tableName, CONFIG_ID or CONFIG_NAME)
$query=new AirpressQuery("Cuisines", CONFIG_NAME);
$query->filterByFormula("{Name}='Burgers'");


//$query->addFilter("{Name}='Burgers'");
// Add
	

$cuisines= new AirpressCollection($query);

// usage: $AirpressCollection->populateRelatedField($columnName, $relatedTableName)
$cuisines->populateRelatedField("Restaurants","Restaurants");
//$cuisines->populateRelatedField("District","City Districts");

$burger_joints=$cuisines[0]["Restaurants"];



if(! is_airpress_empty($burger_joints)){
	foreach($burger_joints as $restaurant){
		//print_r($item);
		
		echo "Name ".$restaurant["Name"]."<br>";
		echo "Status ".$restaurant["Status"]."<br>";
		echo "Cuisine ".$restaurant["Cuisine"]."<br>";
		echo "District ".$restaurant["District"]."<br>";
		echo "<hr>";
	}	
}else{
echo "no collection";
}


// List all restaurants
		echo "<hr>ALL RESTAURANTS<hr>";
	
// usage: AirPressQuery($tableName, CONFIG_ID or CONFIG_NAME)
$query=new AirpressQuery("Restaurants", CONFIG_NAME);
//$query->addFilter("{District}='The Marina'");
$all_restaurants= new AirpressCollection($query);
$all_restaurants->populateRelatedField("Restaurants","Restaurants");
$all_restaurants->populateRelatedField("District","City Districts");



if(! is_airpress_empty($all_restaurants)){
	foreach($all_restaurants as $one_restaurant){
		
		
		
		
		//print_r($item);		
		echo "Name ".$one_restaurant["Name"]."<br>";
		echo "Status ".$one_restaurant["Status"]."<br>";
		echo "District ".$one_restaurant["District"][0]["Name"]."<br>";
		echo "Cuisine ".$one_restaurant["Cuisine"][0]["Name"]."<br>";
		echo "<hr>";
	}	
}else{
echo "no collection";
}


echo "hi 2";
?>
			
			</div>
		</article>
		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
