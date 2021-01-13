<?php /* Template Name: AP-IndividualProject */ ?>

<? get_header(); ?>

<div id="main-content" class="main-content">

<?php
if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
	// Include the featured content template.
	get_template_part( 'featured-content' );
}
?>
	
	
<?php
	//Get Project 
	$passed_project=$_GET['slug'];
	//$passed_project='research-now';
	
//Get Project Details
$query = new AirpressQuery();
$query->setConfig("NYPLdoc1");
$query->table("Projects");
$query->filterByFormula("{Slug}='$passed_project'");
$projects = new AirpressCollection($query);
	
$this_project=$projects[0];		
$this_project_name=$this_project["Project Name"];	
	
//Get Templates from "Templates to Projects LookUp" 
$query2 = new AirpressQuery();
$query2->setConfig("NYPLdoc1");
$query2->table("Templates to Projects LookUp");
$query2->filterByFormula("{Project}='$this_project_name'");
$templates_used = new AirpressCollection($query2);
// Connect linked template w template name
//$templates_used->populateRelatedField("Template","Templates");
//$these_templates=$templates_used[0]["Templates"];
$num_templates= count($templates_used);

?>
			
	
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
<article id="post-1" class="post-1 post type-post status-publish format-standard hentry category-uncategorized">
	
	<header class="entry-header">
		<h1 class="entry-title"><?php  echo $this_project["Project Name"]; ?></h1>
		<!-- .entry-meta -->
	</header><!-- .entry-header -->
	
		<div class="entry-content">
	<?php echo "Passed Project :".$passed_project."<br>"; ?>
			
			Project State 1: <?php  echo $this_project["Project State"]; ?> <br>
			Project Description: <span class="themsthebreaks"><?php  echo $this_project["Project Description"]; ?> </span><br>

			<?php
				echo "<b>".$num_templates." templates used</b><br>";
foreach($templates_used as $e){
	//print_r($templates_used[0]);
	//echo "<br>Template ".$e['Template'];
	echo "<br>Template[0] ".$e['Template'][0][0];
	echo "<br><strong>Template Temp</strong>".$e['Template Temp'];
	echo "<br><strong>Notes</strong> ".$e['Notes'];
	echo "<br><strong>Description</strong> ".$e['Template Description'][0];
	echo "<hr>";
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
