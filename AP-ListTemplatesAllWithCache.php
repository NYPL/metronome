<?php /* Template Name: AP-ListTemplatesAllWithCache */ ?>

<? get_header(); ?>

<div id="main-content" class="main-content">

<?php
// if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
// 	// Include the featured content template.
// 	get_template_part( 'featured-content' );
// }
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
	define("CONFIG_NAME", $GLOBALS['config_name']);
			
?>
			
			
<?php

	$cacheFileName = 'alltemplates';

	$cacheFileLocation = getCacheFileLocation($cacheFileName);
    
    // clear cache on demand with query string var
    if(isset($_GET['fresh'])) {
        unlink($cacheFileLocation);
    }

    $cacheValid = isCacheValid($cacheFileLocation);
    
	if($cacheValid){
        
		echo loadCache($cacheFileLocation);
    
    } else {
	
		
	//print_r(scandir($cacheDir));
	//echo __DIR__;
//////// GET TEMPLATES
	// usage: AirPressQuery($tableName, CONFIG_ID or CONFIG_NAME)
	$query = new AirpressQuery("Templates", CONFIG_NAME);
	$query->sort("Template Name","asc");
	$templates= new AirpressCollection($query);
	$templates->populateRelatedField("IA","UX Status");
	$templates->populateRelatedField("Design","UX Status");
	$templates->populateRelatedField("Accessibility Status","UX Status");
	$templates->populateRelatedField("Design Tech","UX Status");	

if(! is_airpress_empty($templates)){
	$num_templates=count($templates);
	
	$code = "<h2>".$num_templates." Template(s)</h2>";
	
	$code .= "<table>";
	
	$templates_display="";
	foreach($templates as $e){
		$T_Record_ID=$e["Record ID"];
		$T_Name=$e["Template Name"];
		$T_Description=$e["Template Description"];
		$T_Open_Issues=$e["Open Issues"];
		
		$T_View_Link=$GLOBALS['templates_base_folder'].$e["Slug"]."/";
		
		//$T_View_Link="<a href='".$T_View_Link."' target='new'>".$e["Template Name"]."</a>";
		
		$T_Edit_Link=$GLOBALS['templates_edit_link'].$T_Record_ID."?blocks=hide";
		$T_Edit_Link="<a href='".$T_Edit_Link."' target='new'>".$GLOBALS['icon_edit']."</a>";

		$IA_Status=$e["IA"][0]["Name"];
		$Design_Status=$e["Design"][0]["Name"];
		$Accessibility_Status=$e["Accessibility Status"][0]["Name"];
		$Design_Tech_Status=$e["Design Tech"][0]["Name"];
		//$IA_Status=set_style_to_status($IA_Status, "");
		//$Design_Status=set_style_to_status($Design_Status, "");
		//$Design_Tech_Status=set_style_to_status($Design_Tech_Status, "");
		//$IA_Status=set_style_to_status($IA_Status, "IA");
		//$Design_Status=set_style_to_status($Design_Status, "Design");
		//$Design_Tech_Status=set_style_to_status($Design_Tech_Status, "Design Technology");
		
		$templates_display.=return_project_item_row($T_View_Link, $T_Name, $IA_Status, $Design_Status, $Accessibility_Status, $Design_Tech_Status, $Overall_Status, $T_Edit_Link, $T_Description);
		
		
		}
	$code .= $templates_display;
	$code .= "</table>";

	echo $code;
			
}else{
		echo "There are no templates";
}

		file_put_contents($cacheFileLocation, $code);
		echo "File Written";
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