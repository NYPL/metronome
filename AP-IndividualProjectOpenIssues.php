<?php /* Template Name: AP-IndividualProjectOpenIssues */ ?>

<? get_header(); ?>

<div id="main-content" class="main-content">

<?php
if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
	// Include the featured content template.
	get_template_part( 'featured-content' );
}
?>
	
<?php
//////// VARIABLES
// Config
	define("CONFIG_ID", 0);
	define("CONFIG_NAME", "NYPLdoc1");
// Templates folder link
	$base_folder_link="/templates/";	
// Link to MVP edit form
	$base_edit_link="https://airtable.com/tblbFF9urE24fqiVs/viw4VhxrCWn657ezj/";
//Get Project from URL
	$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?  "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI']; 
	$passed_project = array_slice(explode('/', $url), -2)[0];
	// note: passed project is not useful in queries, since names are case sensitive. Use "Slug" or "Project Name" from the query instead
?>
	
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
<article id="post-1" class="post-1 post type-post status-publish format-standard hentry category-uncategorized">
	
	
<? 
//////// PROJECT QUERY
	// usage: AirPressQuery($tableName, CONFIG_ID or CONFIG_NAME)
	$query=new AirpressQuery("Projects", CONFIG_NAME);
	$query->filterByFormula("{Slug}='$passed_project'");
	$projects= new AirpressCollection($query);
	$projects->populateRelatedField("Project State","Project Status");
	$projects->populateRelatedField("Portfolio","Portfolios");
	// Get just this project
	$this_project=$projects[0];		
	$P_Record_ID=$projects[0]["Record ID"];
	// What's it's name?
	$this_project_name=$this_project["Project Name"];	
	$this_project_slug=$this_project["Slug"];
?>
	
<?php
//////// DISPLAY PROJECT DETAILS
if(! is_airpress_empty($projects)){
	foreach($projects as $e){
		$card_wrap="yes";
		$showlink="no";
		$base_folder="na";
		$slug="na";
		$project_name=$e["Project Name"];
		$portfolio=$e["Portfolio"][0]["Name"];
		$portfolio_slug=$e["Portfolio"][0]["Slug"];
		$status=$e["Project State"][0]["Name"];
		$launch_date=$e["Project Launch Date"];
		$project_description=$e["Project Description"];
		$jira_ticket=$e["Jira Ticket"];
		$include_link="no";
		$include_edit="yes";
		$record_id=$e["Record ID"];
		//set display
		$portfolio_card=return_project_card($card_wrap, $base_folder, $slug, $project_name, $portfolio,$portfolio_slug, $status, $launch_date, $project_description, $jira_ticket, $include_link, $include_edit, $record_id);
			}

		}else{
		echo "no collection";
		}	
?>
		
	
<header class="entry-header">
		<?php
			$temp_title=$this_project_name;
			$temp_edit_Link="<a href='".$base_edit_link.$P_Record_ID."/' target='new'>edit</a>";
			$temp_header=return_display_header($temp_title, $temp_edit_Link);
			//echo $temp_header;
	echo $portfolio_card;
		?>
		<!-- .entry-meta -->
	</header><!-- .entry-header -->
	
		<div class="entry-content">
			
			
<?php
			
//////// RELATED DOCS QUERY
	/// Get docs from Related Materials 
	// usage: AirPressQuery($tableName, CONFIG_ID or CONFIG_NAME)
	$query=new AirpressQuery("Related Materials", CONFIG_NAME);
	$query->filterByFormula("{Project}='$this_project_name'");
	$query->sort("Last Modified","desc");
	$related_docs= new AirpressCollection($query);
			
			
	
?>
				
	
			
<?php
			
//////// SET UP TO DISPLAY BOTH TEMPLATES AND COMPONENTS
			// Need list of templates to get related components
			$All_Templates="";
			
			
//////// TEMPLATES QUERY
	/// Get templates from lookup table 
	// usage: AirPressQuery($tableName, CONFIG_ID or CONFIG_NAME)
	$query=new AirpressQuery("Templates to Projects LookUp", CONFIG_NAME);
	$query->filterByFormula("{Project}='$this_project_name'");
	$query->sort("Template","asc");
	$templates= new AirpressCollection($query);
	// connect related fields (Column, Table)
	$templates->populateRelatedField("Template","Templates");
	// Breaks my brain
	$templates->populateRelatedField("Template|IA","UX Status");
	$templates->populateRelatedField("Template|Design","UX Status");
	$templates->populateRelatedField("Template|Design Tech","UX Status");
	$templates->populateRelatedField("Template|Accessibility Status","UX Status");
	
	$T_base_edit_url="https://airtable.com/tblN4ml1RFKA5dEKZ/viwXTL0bK4Oys5sJS/";
			
	// Begining of hack, create array to hold componenets attached to a template
	$all_components_raw=array();
?>
			
<?php
	//////// DISPLAY TEMPLATES
	if(! is_airpress_empty($templates)){
		$num_templates=count($templates);
		
		$templates_display="<h3>".$num_templates." Template(s) Used</h3>";
		// link to add or remove a template shoudl go here
		$templates_display.="<table>";
			foreach($templates as $e){
				$view_link=$base_folder_link.$e["Template"][0]["Slug"];
				$T_Name=$e["Template"][0]["Template Name"];
				$T_Record_ID=$e["Template"][0]["Record ID"];
				$IA_Status=$e["Template"][0]["IA"][0]["Name"];
				$Design_Status=$e["Template"][0]["Design"][0]["Name"];
				$Design_Tech_Status=$e["Template"][0]["Design Tech"][0]["Name"];
				$Acessibility_Status=$e["Template"][0]["Acessibility Status"][0]["Name"];

				$IA_Status=set_style_to_status($IA_Status, "IA");
				$Design_Status=set_style_to_status($Design_Status, "Design");
				$Design_Tech_Status=set_style_to_status($Design_Tech_Status, "Design Technology");
				$Acessibility_Status=set_style_to_status($Acessibility_Status, "Acessibility");
				
				
				$T_Edit_Link=$T_base_edit_url.$T_Record_ID."?blocks=hide";
				
				// Add this templates to list of templates used in this project
				$All_Templates.=$T_Name." |";
				
				///// THIS IS AWFUL
				///// Get my Open Issues through an individual call
				$query_for_open_issues=new AirpressQuery("Open Issues", CONFIG_NAME);
				$filter_formula="{Template Name}='$T_Name' ";
				$query_for_open_issues->filterByFormula($filter_formula);
				//$query->filterByFormula($query);
				$query_for_open_issues->sort("Resolved","asc");
				$t_template_open_issues= new AirpressCollection($query_for_open_issues);
				$these_issues="<table>";
				$resolved_issues="";
					foreach($t_template_open_issues as $aargh){
						$t_record_id=$aargh["Record ID"];
						$these_issues_edit="<a href='https://airtable.com/tbl401gXwwvqhjlEY/viwefZa7OLF9qrDfl/$t_record_id?blocks=hide' target='new'>edit</a>";
						$these_issues_resolved="";
						$t_oi=make_markdown($aargh["Open Issue"]);
						if(! empty($aargh["Resolved"])){
							$these_issues_resolved=make_markdown("<strong>Resolved: </strong>".$aargh["Solution"]);
							$resolved_issues.="<tr><td width='15%' class='resolved_oi'><strong>".$aargh["Type"]."</strong></td><td class='resolved_oi'>".$t_oi.$these_issues_resolved."  | ".$these_issues_edit."</td></tr>";
						}else{
							$these_issues.="<tr><td width='15%'><strong>".$aargh["Type"]."</strong></td><td>".$t_oi.$these_issues_resolved."  | ".$these_issues_edit."</td></tr>";
						}
						
					}
				$these_issues.=$resolved_issues."</table>";

				$templates_display.="<tr>";
					$templates_display.="<td><h4><a href='".$view_link."'>".$T_Name."</a></h4></td>";	
					$templates_display.="<td class='align_right'><a href='".$T_Edit_Link."'>edit</a>  ".$IA_Status.$Design_Status.$Accessibility_Status.$Design_Tech_Status."</td>";
				$templates_display.="</tr>";
				$templates_display.="<tr>";
					$templates_display.="<td colspan=2>$these_issues</td>";
				$templates_display.="</tr>";
				
				
				//Get My COMPONENTS
				//$all_components_raw=array();
				$query_for_components=new AirpressQuery("Component to Template LookUp", CONFIG_NAME);
				$filter_formula="{Template}='$T_Name' ";
				$query_for_components->filterByFormula($filter_formula);
				//$query->filterByFormula($query);
				$query_for_components->sort("Component","asc");
				$project_components= new AirpressCollection($query_for_components);
				$project_components->populateRelatedField("Component","Components");
				$project_components->populateRelatedField("Component|IA","UX Status");
				$project_components->populateRelatedField("Component|Design","UX Status");
				$project_components->populateRelatedField("Component|Design Tech","UX Status");	
				$project_components->populateRelatedField("Component|Accessibility Status","UX Status");	
				
				foreach($project_components as $e){
					//what fields do I need
					$C_Name=$e["Component"][0]["ComponentName"];
					$IA_Status=$e["Component"][0]["IA"][0]["Name"];
					$Design_Status=$e["Component"][0]["Design"][0]["Name"];
					$Design_Tech_Status=$e["Component"][0]["Design Tech"][0]["Name"];
					$Accessibility_Status=$e["Component"][0]["Accessibility Status"][0]["Name"];
					$C_View_Link="/components/".$e["Component"][0]["Slug"]."/";
					$C_Record_ID=$e["Component"][0]["Record ID"];
					//FIX need to place variables in one place 
					$base_edit_link="https://airtable.com/tblYWtfeJcUcaW92U/viw8LSUoCBYaxOX1N/";
					$C_Edit_Link=$base_edit_link.$C_Record_ID."?blocks=hide";
					$C_Edit_Link="<a href='".$C_Edit_Link."'>edit</a>";
				
					
					// make a little array and dump it in
					$temp_array = array(
							"name" => $C_Name,
							"ia" => $IA_Status,
							"des"   => $Design_Status,
							"dt"   => $Design_Tech_Status,
							"ac"   => $Accessibility_Status,
							"link"  => $C_View_Link,
							"edit"  => $C_Edit_Link,
						);
					//if I don't already exist in larger array, add me
					if (! array_key_exists($C_Name, $all_components_raw)) {
							$all_components_raw += array($C_Name => $temp_array);
						}			
				}
			}

		$templates_display.="</table>";
	}else{
		echo "There are no templates associated with this project";
	}
				
			// Ideally would use this to buidl a simpler query and avoid the new array echo "All_Templates ".$All_Templates;
	
			
			//////// DISPLAY COMPONENTS
			$U_Num_Components=count($all_components_raw);
			sort($all_components_raw);
			$component_display.="<h3>".$U_Num_Components." Component(s) Used</h3>";
			// FIX put in handling where there are no components etc
			$component_display.="<table>";
			foreach($all_components_raw as $e){
				$C_Name=$e["name"];
				
				$IA_Status=set_style_to_status($e["ia"],"IA");
				$Design_Status=set_style_to_status($e["des"],"Design");
				$Design_Tech_Status=set_style_to_status($e["dt"],"Design Technology");
				$Acessibility_Status=set_style_to_status($e["ac"], "Acessibility");
			
				
				///// THIS IS AWFUL
				///// Get my Open Issues through an individual call
				$query_for_open_issues=new AirpressQuery("Open Issues", CONFIG_NAME);
				$filter_formula="{ComponentName}='$C_Name' ";
				$query_for_open_issues->filterByFormula($filter_formula);
				//$query->filterByFormula($query);
				$query_for_open_issues->sort("Resolved","asc");
				$c_template_open_issues= new AirpressCollection($query_for_open_issues);
				
				$these_issues="";
				$resolved_issues="";
					foreach($c_template_open_issues as $aargh){
						$t_record_id=$aargh["Record ID"];
						$these_issues_edit="<a href='https://airtable.com/tbl401gXwwvqhjlEY/viwefZa7OLF9qrDfl/".$t_record_id."?blocks=hide' target='new'>edit</a>";
						$these_issues_resolved="";
						$t_oi=make_markdown($aargh["Open Issue"]);
						
						if(! empty($aargh["Resolved"])){
							$these_issues_resolved=make_markdown("<strong>Resolved: </strong>".$aargh["Solution"]);
							$resolved_issues.="<tr><td width='15%' class='resolved_oi'><strong>".$aargh["Type"]."</strong></td><td class='resolved_oi'>".$t_oi.$these_issues_resolved."  | ".$these_issues_edit."</td></tr>";
						}else{
							$these_issues.="<tr><td width='15%'><strong>".$aargh["Type"]."</strong></td><td>".$t_oi.$these_issues_resolved."  | ".$these_issues_edit."</td></tr>";
						}
					}
				
				
			
						
				
				
				
				//$these_issues="";
				
				$component_display.="<tr>";
					$component_display.="<td>".$IA_Status.$Design_Status.$Acessibility_Status.$Design_Tech_Status."</td>";
					$component_display.="<td ><a href='".$e["link"]."'><h4>".$e["name"]."</a></h3></td>";
					$component_display.="<td style='text-align:right;'>".$e["edit"]."</td>";
				$component_display.="</tr>";
				$component_display.=$these_issues.$resolved_issues;

			}
			$component_display.=$resolved_issues."</table>";
	
			
			
			
			
						
						
			//// LINK TO PROJECT PAGE
			$link_to_pr="/projects/".$this_project_slug;
			$link_to_pr="<a href='$link_to_pr'>View Project Overview</a>";
			//// BUILD PAGE
			echo "<h2><span class='urgent_message'>Open Issues</span></h2><table><tr><td ><strong>$link_to_pr</strong><br><br><br></td></tr><tr><td width='65%'>$templates_display $component_display</td></tr></table>";
			//// BUILD PAGE
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
