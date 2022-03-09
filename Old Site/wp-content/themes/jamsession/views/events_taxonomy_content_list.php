<?php
    /**
     * @var $the_query - WP_Query object
     */
?>

<div id="post_content_container_list">

	<?php	
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts()) {
			
				$the_query->the_post();

				$event_date = esc_html( get_post_meta( get_the_ID(), 'event_date', true ) );
				if ( $event_date != "")
				{
					@$event_date = str_replace("/","-", $event_date);
					@$dateObject = new DateTime($event_date);
				}
				$event_location = esc_html( get_post_meta( get_the_ID(), 'event_location', true ) );
				$event_date_computed = phpversion() >= "5.3" ? date_i18n(get_option('date_format'), $dateObject->getTimestamp()) : date_i18n(get_option('date_format'), $dateObject->format('U'));
				$event_venue = esc_html( get_post_meta( get_the_ID(), 'event_venue', true ) );
				$event_buy_tickets_message = esc_html( get_post_meta( get_the_ID(), 'event_buy_tickets_message', true ) );
				$event_buy_tickets_url = esc_html( get_post_meta( get_the_ID(), 'event_buy_tickets_url', true ) );				
				?>
				
				<div class="event_item_list">
					<div class="event_date_list">
						<?php echo $event_date_computed; ?>
					</div>
					
					<div class="event_location_list">
						<a href="<?php the_permalink(); ?>"> <?php echo $event_location; ?> </a>
					</div>
					
					<div class="event_venue_list">
						<a href="<?php the_permalink(); ?>"> <?php echo $event_venue; ?> </a>
					</div>
					
					<div class="event_buy_list">
						<a href="<?php echo $event_buy_tickets_url; ?>"> <?php echo $event_buy_tickets_message; ?> </a> 
					</div>
					<div class="clearfix"></div>
				</div>
		<?php
		}
	}
	?>
</div>