<?php /* Template Name: AP-ListAll */ ?>
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
		<h1 class="entry-title">All Templates</h1>
		<!-- .entry-meta -->
	</header><!-- .entry-header -->
	
		<div class="entry-content">
			
			
			
<?php
//////// VARIABLES
// Config
	define("CONFIG_ID", 0);
	define("CONFIG_NAME", "NYPLdoc1");
// Templates folder link
	$base_folder_link="/templates/";	
// Link to MVP edit form
	$base_edit_link="https://airtable.com/tblN4ml1RFKA5dEKZ/viwXTL0bK4Oys5sJS/";
			
?>
			
			
<?php

//////// GET TEMPLATES
	// usage: AirPressQuery($tableName, CONFIG_ID or CONFIG_NAME)
	$query=new AirpressQuery("Templates", CONFIG_NAME);
	$query->sort("Template Name","asc");
	$templates= new AirpressCollection($query);
	$templates->populateRelatedField("IA","UX Status");
	$templates->populateRelatedField("Design","UX Status");
	$templates->populateRelatedField("Design Tech","UX Status");	

if(! is_airpress_empty($templates)){
	$num_templates=count($templates);
	echo "<h2>".$num_templates." Template(s)</h2>";
	
	echo "<table>";
		echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo "<td>IA</td>";	
			echo "<td>Design</td>";
			echo "<td>Des Tech</td>";
			echo "<td>&nbsp;</td>";
		echo "</tr>";
	
	foreach($templates as $e){
		$T_Record_ID=$e["Record ID"];
		$T_Name=$e["Template Name"];
		
		$T_View_Link=$base_folder_link.$e["Slug"]."/?fresh=true";
		$T_View_Link="<a href='".$T_View_Link."'>".$e["Template Name"]."/</a>";

		$IA_Status=$e["IA"][0]["Name"];
		$Design_Status=$e["Design"][0]["Name"];
		$Design_Tech_Status=$e["Design Tech"][0]["Name"];
		$IA_Status=set_style_to_status($IA_Status);
		$Design_Status=set_style_to_status($Design_Status);
		$Design_Tech_Status=set_style_to_status($Design_Tech_Status);
		//$Design_Tech_Status=set_style_to_status($Design_Tech_Status, "Design Technology");

		echo "<tr>";
			echo "<td><h3>".$T_View_Link."</h3></td>";
			echo "<td>".$IA_Status."</td>";	
			echo "<td>".$Design_Status."</td>";
			echo "<td>".$Design_Tech_Status."</td>";
		echo "</tr>";
		
	echo "</table>";
			
}else{
		echo "There are no templates";
}

			
			
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
