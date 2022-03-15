<?php
    /**
     * @var $the_query - WP_Query object
     */
?>

<div id="post_content_container" data-columns>

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
				?>
				
				<div class="post_item">
					<div class="post_item_event_container">
							<?php
								if (has_post_thumbnail()) 
								{
									?>
									<a href="<?php the_permalink(); ?>">
										<div class="post_image_container">
										
											<div class="post_icon_more">
												<i class="icon-link"></i>
											</div>
											<div class="post_fader"></div>
										
											<?php the_post_thumbnail('medium'); ?>
										</div>
									</a>
									<?php
								}
							?>
							<div class="event_brick_date">
								<?php 
								if (phpversion() >= "5.3") {
									echo date_i18n(get_option('date_format'), $dateObject->getTimestamp()); 
								} else {
									echo date_i18n(get_option('date_format'), $dateObject->format('U')); 
								} ?>
							</div>
							
							<div class="post_item_title">
								<a href="<?php the_permalink(); ?>"> <?php  the_title(); ?> </a>
							</div>

							<div class="event_brick_venue">
								<?php echo $event_location; ?>
							</div>
					</div>
				</div>
		<?php
		}
	}
	?>
</div>