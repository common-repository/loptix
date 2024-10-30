<?php
/*
Plugin Name: Loptix
Plugin URI: http://loptix.com/widget.php
Description: Real time link exchange
Version: 0.4
Author: Martin Lazarov
Author URI: http://marto.lazarov.org
*/
/*
 * Created: 2009.01.15
 * Updated: 2010.03.09
 * Created by Martin Lazarov
 * Changelog:
 * 2009.01.15 - First version (mlazarov)
 * 2010.03.09 - Added Language parameter
 * 2011.03.28 - Bugfix
 */
if (class_exists('WP_Widget')) {
class Loptix_Widget extends WP_Widget {
	var $languages =array(
		0 => "Multilingual",
		1 => "Bulgarian",
		2 => "Russian",
		3 => "English",
		4 => "Spanish",
		5 => "German",
		6 => "French",
		7 => "Italian",
		8 => "Greek",
		9 => "Hungarian",
		10 => "Macedonian",
		11 => "Polish",
		12 => "Portuguese",
		13 => "Romanian",
		14 => "Turkish",
		15 => "Ukrainian");
	function Loptix_Widget(){
		$widget_ops = array('classname' => 'widget_rss', 'description' => 'A free exchange links system' );
		$this->WP_Widget('rss_links', 'Loptix', $widget_ops);
		
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		
		echo $before_widget;
		
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$width = empty($instance['width']) ? '99%' : apply_filters('widget_width', $instance['width']);	
		$height = empty($instance['height']) ? '300' : apply_filters('widget_height', $instance['height']);
		$language = empty($instance['language']) ? 0 : apply_filters('widget_language', $instance['language']);
		
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		
		$params = array();
		if($language) $params[]='l='.$language;
		
		echo '<center><iframe src="http://loptix.com/widget/links.php'.(count($params)?'?'.implode('&',$params):'').'" width="'.$width.'" height="'.$height.'" style="border:0px" frameborder="0"></iframe></center>';
		echo '<div style="text-align:right;font-size:11px;padding-right:10px;"><a href="http://loptix.com/" target="_blank">Loptix - link sharing system</a></div>';
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['height'] = strip_tags($new_instance['height']);
		$instance['language'] = strip_tags($new_instance['language']);
		return $instance;
	}
	function form($instance) {		
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Интересно из нета', 'width' => '300', 'height' => '400' ) );
		$title = strip_tags($instance['title']);
		$width = strip_tags($instance['width']);
		$height = strip_tags($instance['height']);
		
		$language = strip_tags($instance['language']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('width'); ?>">Box width: <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo attribute_escape($width); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('height'); ?>">Box height: <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo attribute_escape($height); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('language'); ?>">Language:
				<select class="widefat" id="<?php echo $this->get_field_id('language'); ?>" name="<?php echo $this->get_field_name('language'); ?>">
				<?
				foreach($this->languages as $lid=>$lname){
					echo '<option value="'.$lid.'"'.($language==$lid?' selected="selected"':'').'>'.$lname."</option>";
				}?>
				</select>
		 	</label>
		</p>
		<?php
	}
	function register(){
		
	}
}
function LoptixInit() {
	register_widget('Loptix_Widget');
}

add_action('widgets_init', 'LoptixInit');
}
?>