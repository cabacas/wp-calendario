<?php
/**
 * Plugin Name: WP Calendario
 * Plugin URI: http://www.rayflores.com/plugins/wp-calendario/ 
 * Version: 1.0
 * Author: Ray Flores
 * Author URI: http://www.rayflores.com 
 * Description: a responsive calender extended from Ccdrops Calendario
 * Requires at least: 4.0
 * Tested up to: 4.1
 */
add_action('init', 'my_init_function');
function my_init_function() {
	/* Make sure the plugin is installed and active */
	if(!defined('FF_INSTALLED')) {
		return;
	}
	// Add your function calls here!
	ff_create_section('wp-calendario-section', 'admin_menu', array(
			'page_title' => 'WP Calendario',
			'menu_title' => 'WP Calendario',
			'capability' => 'edit_posts',
			'position' => 999,
		)
	);
	ff_create_section('wp-calendario-settings', 'admin_sub_menu', array(
			'parent_uid' => 'wp-calendario-section',
			'page_title' => 'Calendario Settings',
			'menu_title' => 'Calendario Settings',
			'capability' => 'edit_posts',
		)
	);
	ff_create_field('the-rangedate-year','datetime',array(
		'label' => 'Single Display Year',
		'date_format' => 'yy',
		'time_format' => -1,
		)
	);
	ff_create_field('the-rangedate-min-month','datetime',array(
			'label' => 'Minimum Month',
			'date_format' => 'mm',
			'time_format' => -1,
		)
	);
	ff_create_field('the-rangedate-max-month','datetime', array(
			'label' => 'Maximum Month',
			'date_format' => 'mm',
			'time_format' => -1,
		)
	);
	ff_create_field('the-datetime', 'datetime', array(
			'label' => 'Date',
			'date_format' => 'mm-dd-yy',
			'time_format' => -1,
		)
	);
	ff_create_field('title-text-field', 'text', array(
			'label' => 'Label',
		)
	);
	ff_create_field('calendar-title-text-field', 'text', array(
			'label' => 'Calendar Title',
		)
	);
	ff_create_field('wp-calendario-group-field', 'group', array(
		'label' => __('Calendar Entry', 'fields-framework'),
		'repeatable' => true,
	));
	ff_create_field('wp-calendario-daterange-group','group', array(
				'label' => 'Date Ranges',
				'id' => 'date-ranges-group',
		)
	);
	ff_create_field('wp-calendario-double-nested-repeatable-group-field', 'group', array(
			'label' => 'Calender Single Date Multiple Labels',
			'repeatable' => true,
		)
	);	
	ff_add_field_to_field_group('wp-calendario-daterange-group','the-rangedate-year');
	ff_add_field_to_field_group('wp-calendario-daterange-group','the-rangedate-min-month');
	ff_add_field_to_field_group('wp-calendario-daterange-group','the-rangedate-max-month');
	ff_add_field_to_field_group('wp-calendario-group-field', 'the-datetime');
	ff_add_field_to_field_group('wp-calendario-double-nested-repeatable-group-field', 'title-text-field');
	ff_add_field_to_field_group('wp-calendario-group-field', 'wp-calendario-double-nested-repeatable-group-field');
	
	ff_create_field('wp-calendario-nested-repeatable-group-field', 'group', array(
			'label' => 'Calender Group Fields',
			'repeatable' => true,
		)
	);

	//ff_add_field_to_section('wp-calendario-settings','wp-calendario-daterange-group');
	ff_add_field_to_section('wp-calendario-settings','wp-calendario-nested-repeatable-group-field');
	ff_add_field_to_field_group('wp-calendario-nested-repeatable-group-field','calendar-title-text-field');
	ff_add_field_to_field_group('wp-calendario-nested-repeatable-group-field','wp-calendario-daterange-group');
	ff_add_field_to_field_group('wp-calendario-nested-repeatable-group-field', 'wp-calendario-group-field');
	//ff_add_field_to_field_group('wp-calendario-nested-repeatable-group-field','wp-calendario-double-nested-repeatable-group-field');
	
	
}
// see all fields array in backend settings
//add_action('ff_section_after', 'ff_field_testing_after_all');
function ff_field_testing_after_all($section_uid) {
	if($section_uid == 'wp-calendario-settings') {
		echo '<pre>';
		print_r(ff_get_all_fields_from_section($section_uid, 'options'));
		echo '</pre>';
	}
}
function load_custom_wp_admin_style() {
        wp_register_style( 'wp_calendario_admin_css', plugin_dir_url(__FILE__) . '/css/wp_calendario_admin.css', false, '1.0.1' );
        wp_enqueue_style( 'wp_calendario_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

add_action('wp_enqueue_scripts','rfwp_register_scripts_all');
function rfwp_register_scripts_all(){
	 wp_register_script( 'calendario-script', plugins_url( 'js/jquery.calendario.js', __FILE__), array('jquery') );
	 wp_register_script( 'calendario-script-data', plugins_url( 'js/data.js', __FILE__) );
	 wp_register_script( 'calendario-script-datatimeline', plugins_url( 'js/dataTimeline.js', __FILE__ ) );
	 wp_register_script( 'calendario-script-modernizr', plugins_url( 'js/modernizr.custom.63321.js', __FILE__ ), array('jquery') );
	 //wp_register_script( 'calendario-script-update', plugins_url( 'js/update.js', __FILE__ ) );
	 wp_register_style( 'calendario-style', plugins_url( 'css/calendar.css', __FILE__ ) );
	 wp_register_style( 'calendario-style-1', plugins_url( 'css/custom_1.css', __FILE__ ),false, '1.0.4' );
	 wp_register_style( 'calendario-style-2', plugins_url( 'css/custom_2.css', __FILE__ ) );
	 wp_register_style( 'calendario-style-3', plugins_url( 'css/custom_3.css', __FILE__ ) );
	 wp_register_style( 'calendario-style-4', plugins_url( 'css/custom_4.css', __FILE__ ) );
	 wp_register_style( 'calendario-style-demo', plugins_url( 'css/demo.css', __FILE__ ) );
	 wp_register_style( 'calendario-style-timeline', plugins_url( 'css/timeline.css', __FILE__ ) );
}

function lowercasedash($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}
// shortcode:  [calendario id="value of title"] //
add_shortcode('calendario','calendario');
function calendario($atts){
	
	$section_uid = 'wp-calendario-settings';
	$fields_group = ff_get_all_fields_from_section($section_uid, 'options');

	$calendar_name = '';
	$s = shortcode_atts( array(	'id' => '' ), $atts );
	$key = array();
	$looking_for = $s['id'];
	foreach( $fields_group['wp-calendario-nested-repeatable-group-field'] as $j => $calendar ) {
		
		if( $calendar['calendar-title-text-field'] == $looking_for ) { 
		$key[] = $j; 
		}
		$selectors[] = $calendar['calendar-title-text-field'];
	}

 	if( count( $key ) > 0 ) {
	$index = $key[0];
	$rangeYear = $fields_group['wp-calendario-nested-repeatable-group-field'][$index]['wp-calendario-daterange-group']['the-rangedate-year'];
	$rangeMaxmonth = $fields_group['wp-calendario-nested-repeatable-group-field'][$index]['wp-calendario-daterange-group']['the-rangedate-max-month'];	
	$rangeMinmonth = $fields_group['wp-calendario-nested-repeatable-group-field'][$index]['wp-calendario-daterange-group']['the-rangedate-min-month'];

	$theCurrentMonth = date('m');
//	$theCurrentMonth = '08';
			// current is before minrange
		if ($rangeMinmonth >= $theCurrentMonth && $rangeMaxmonth >= $theCurrentMonth) {
			$theinitMonth = $rangeMinmonth;
		}	
		// current is in range
		 elseif ($rangeMinmonth <= $theCurrentMonth && $rangeMaxmonth >= $theCurrentMonth) {
			$theinitMonth = $theCurrentMonth;
		} 
		// current is after maxrange
		elseif ($rangeMinmonth <= $theCurrentMonth && $rangeMaxmonth <= $theCurrentMonth) {
			$theinitMonth = $rangeMaxmonth;
		}

	$title = $fields_group['wp-calendario-nested-repeatable-group-field'][$index]['calendar-title-text-field'];
	$entries = $fields_group['wp-calendario-nested-repeatable-group-field'][$index]['wp-calendario-group-field'];
		// dates	
		$dates_array = null;
		foreach($entries as $key => $entry){
			$date[$key] = $entry['the-datetime'];
			$labels_array = null;
			foreach ($entry['wp-calendario-double-nested-repeatable-group-field'] as $_l => $label){
				$labels_array[] = array('content'=>$label['title-text-field']); 
			}
			
			$labels[$entry['the-datetime']] = $labels_array;  // this!  

		}
		
	//	print_r(json_encode($labels));

	$encoded_data = json_encode($labels);

	$encoded_data = str_replace('"content"','content',$encoded_data);
	$encoded_data = str_replace('"','\'', $encoded_data);
	//print_r(addslashes($encoded_data));
		
	}
		wp_enqueue_style( 'calendario-style');
		wp_enqueue_style('calendario-style-1');
		wp_enqueue_script('calendario-script');
		wp_enqueue_script('calendario-script-modernizr');
		//wp_enqueue_script( 'calendario-script-update');
		
		
	$output = '';
	$output .= '<div class="calendar-here" >';
	// $output .= '<ul class="calendaro-menu">';
		// foreach ($selectors as $selector){
			// $output .= '<li><a href="'.'/opening-times/'. lowercasedash($selector).'/"><button class="btn button-lrg calendario-buttons">'.$selector.'</a></button></li>';
		// }
	// $output .= '</ul>';	
	$output .= '<div class="calendario-container">';
	$output .=	'<div class="custom-calendar-wrap custom-calendar-full">';
	$output .=			'<div class="custom-header clearfix">';
	$output .=				'<h2>'.$title.' - Opening Times</h2>';
	$output .=				'<h3 class="custom-month-year">';
	$output .=					'<span id="custom-month" class="custom-month"></span>';
	$output .=					'<span id="custom-year" class="custom-year"></span>';
	$output .=					'<nav>';
	$output .=						'<span id="custom-prev" class="custom-prev"></span>';
	$output .=						'<span id="custom-next" class="custom-next"></span>';
//	$output .=						'<span id="custom-current" class="custom-current" title="Go to current date"></span>';
	$output .=					'</nav>';
	$output .=				'</h3>';
	$output .=			'</div>'; // end custom-header
	$output .=			'<div id="calendar-'. lowercasedash($title) . '" class="fc-calendar-container"></div>';
	$output .=	'</div>'; // end-custom-calendar-wrap
	$output .= '</div>';  // end calendario-container	
	$output .= '</div>'; // end calendar-here  ////'.stripslashes($encoded_data).'
	$output .='<script>
				jQuery(document).ready(function($) {

				var value = jQuery("#calendarioSelector option:selected").val();		

				var calID = "'. lowercasedash($title) .'";
				var now = new Date("mm");
				var cal = jQuery( "#calendar-"+calID ).calendario( {
						onDayClick : function( $el, $contentEl, dateProperties ) {
							for( var key in dateProperties ) {
								console.log( key + " = " + dateProperties[ key ] );
							}
						},
						month: now, //.$theinitMonth.,
						caldata : '.$encoded_data .' 
					}); 
					$month = $( "#custom-month" ).html( cal.getMonthName() ),
    				 $year = $( "#custom-year" ).html( cal.getYear() );
				
				
				;
				$( "#custom-next" ).on( "click", function() {
					//if(can_do("next")) 
					    cal.gotoNextMonth( updateMonthYear );
				} );
				$( "#custom-prev" ).on( "click", function() {
					//if(can_do("prev")) 
					    cal.gotoPreviousMonth( updateMonthYear );
				} );
				$( "#custom-current" ).on( "click", function() {
					cal.gotoNow( updateMonthYear );
				} );
				function updateMonthYear() {
					$month.html( cal.getMonthName() );
					$year.html( cal.getYear() );
				};
				
				
				function can_do(to_do){
					var min_month = "01";//. $theinitMonth .;
					var max_month="12";//. $rangeMaxmonth .;
					var year="2018"//. $rangeYear . ;
					if(to_do=="next"){
						if( cal.getMonth() > min_month && cal.getMonth() < max_month && cal.getYear() == year ) return true;
						else if(cal.getMonth()== min_month ) return true;
						else return false;
					}
					else if(to_do=="prev"){
						if( cal.getMonth() > min_month && cal.getMonth() < max_month  && cal.getYear() == year ) return true;
						else if(cal.getMonth()== max_month ) return true;
						else return false;
					}
				}
				 
						// });
			});
	</script>';
	
	return $output;
}