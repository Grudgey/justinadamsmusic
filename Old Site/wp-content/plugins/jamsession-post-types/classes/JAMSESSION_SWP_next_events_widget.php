<?php 
class JAMSESSION_SWP_next_events_widget extends WP_Widget {
	/* Sets up the widgets name etc */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget widget_jms_next_events widget_recent_entries',
			'description' => esc_html__('Shows The Next Events', 'jamsession-post-types'),
		);
		parent::__construct('JAMSESSION_SWP_next_events_widget', 'JamSession Next Events', $widget_ops);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget($args, $instance) {
		$allowed_html = array(
			'div'	=> array(
				'id'	=> array(),
				'class'	=> array()
			),
			'li'	=> array(
				'id'	=> array(),
				'class'	=> array()
			),
			'h2'	=> array(
				'id'	=> array(),
				'class'	=> array()
			),
			'h3'	=> array(
				'id'	=> array(),
				'class'	=> array()
			)
		);
		echo wp_kses($args['before_widget'], $allowed_html);
		if (!empty($instance['title'])) {
			echo wp_kses($args['before_title'], $allowed_html) . apply_filters('widget_title', $instance['title']) . wp_kses($args['after_title'], $allowed_html);
		}
		
		$number_of_posts = intval($instance['number_of_posts']);
		$query_args = array(
			'numberposts'	=> $number_of_posts,
			'posts_per_page'   => $number_of_posts,
			'offset'           => 0,
			'category'         => '',
			'orderby'          => array('event_date' => 'ASC', 'event_time' => 'ASC'),
			'order'            => 'ASC',
			'include'          => '',
			'exclude'          => '',
			'meta_key'         => 'event_date',
			'meta_value'       => '',
			'post_type'        => 'js_events',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'post_status'      => 'publish',
			'meta_query' => array(
				'relation' => 'AND',
				'event_date' => array(
				   'key' => 'event_date',
				   'value' => date('Y/m/d',current_time('timestamp')),
				   'compare' => '>='
				),
				'event_time' => array(
				   'key' => 'event_time'
				)				
			),
			'suppress_filters' => false
		);
		
		$my_query = new WP_Query($query_args);
		if ($my_query->have_posts()) {
			echo '<ul>';
			while ($my_query->have_posts()) {
				$my_query->the_post();
				
				$post_id = get_the_ID();
				$event_date = esc_html(get_post_meta($post_id, 'event_date', true));
				 if ($event_date != "") {
					@$event_date = str_replace("/","-", $event_date);
					@$dateObject = new DateTime($event_date);
				}
				?>
				<li>
					<div class="wg_event_date">
						<?php 
							$event_date_computed = phpversion() >= "5.3" ? date_i18n(get_option('date_format'), $dateObject->getTimestamp()) : date_i18n(get_option('date_format'), $dateObject->format('U')); 
							echo $event_date_computed; 
							
						?>
					</div>
					
					<a href="<?php esc_url(the_permalink()); ?>" class="wg_event_name">
						<?php echo esc_html(get_the_title()); ?>
					</a>
					<div class="clearfix"></div>
				</li>
				<?php
			}
			echo '</ul>';
			/* Restore original Post Data */
			wp_reset_postdata();
		}
		echo wp_kses($args['after_widget'], $allowed_html);
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form($instance) {
		// outputs the options form on admin
		$title = !empty($instance['title']) ? $instance['title'] : esc_html__('Upcoming Events', 'jamsession-post-types');
		$number_of_posts = !empty($instance['number_of_posts']) ? intval($instance['number_of_posts']) : '5';
		?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'jamsession-post-types'); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
			
			<label for="<?php echo esc_attr($this->get_field_id('number_of_posts')); ?>"><?php esc_attr_e('Number of posts:', 'jamsession-post-types'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('number_of_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('number_of_posts')); ?>" type="text" value="<?php echo esc_attr(intval($number_of_posts)); ?>">
		</p>
		
		<?php 		
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update($new_instance, $old_instance) {
		// processes widget options to be saved
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : 'Upcoming Events';
		$instance['number_of_posts'] = (!empty($new_instance['number_of_posts'])) ? intval(($new_instance['number_of_posts'])) : '5';

		return $instance;
	}
}