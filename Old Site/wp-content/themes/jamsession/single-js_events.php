<?php
	get_header();
?>
	
<div id="main_content">
	<?php
	
	if (have_posts()) 
	{	
		while (have_posts()) 
		{
			the_post();
			?> 
			<div id="event_poster"> 
				<?php
						/*get the thumbnail */
					the_post_thumbnail('large');
					
					$event_date = esc_html( get_post_meta( get_the_ID(), 'event_date', true ) );
					$event_time = esc_html( get_post_meta( get_the_ID(), 'event_time', true ) );
					
					$event_venue = esc_html( get_post_meta( get_the_ID(), 'event_venue', true ) );
					$event_venue_url = esc_html( get_post_meta( get_the_ID(), 'event_venue_url', true ) );
					
					$event_location = esc_html( get_post_meta( get_the_ID(), 'event_location', true ) );
					
					$event_buy_tickets_message = esc_html( get_post_meta( get_the_ID(), 'event_buy_tickets_message', true ) );
					$event_buy_tickets_url = esc_html( get_post_meta( get_the_ID(), 'event_buy_tickets_url', true ) );
					
					$event_fb_message = esc_html( get_post_meta( get_the_ID(), 'event_fb_message', true ) );
					$event_fb_url  = esc_html( get_post_meta( get_the_ID(), 'event_fb_url', true ) );
					
					//$event_map_url  = esc_html( get_post_meta( get_the_ID(), 'event_map_url', true ) );
					$event_map_url  = get_post_meta( get_the_ID(), 'event_map_url', true );
					
					
					$event_videos_link  = esc_html( get_post_meta( get_the_ID(), 'event_videos_link', true ) );			
					$event_gallery_link  = esc_html( get_post_meta( get_the_ID(), 'event_gallery_link', true ) );	

					if ( ($event_date != "") || ($event_venue != "") || ( $event_location != ""))
					{
						echo '<div class="event_meta">';
						if ( $event_date != "")
						{
							@$event_date = str_replace("/","-", $event_date);
							@$dateObject = new DateTime($event_date);
						?>
							<div class="album_meta_item">
								<?php echo '<span class="album_meta_title">'.strtoupper( __('Date: ', 'jamsession')).'</span>'.date_i18n(get_option('date_format'), $dateObject->format('U'));?>
							</div>
						<?php
						}
							
						if ( $event_time != "")
						{
							$build_time = $event_date." ".$event_time.":00";
							if ( strtotime($build_time))
							{
								$time_obj =  new DateTime($build_time);
								?>
									<div class="album_meta_item">
									<?php 
										echo '<span class="album_meta_title">'.strtoupper( __('Time: ', 'jamsession')).'</span>'.$time_obj->format(get_option('time_format'));
									?>
									</div>
								<?php
							}
							else
							{
								?>
								<div class="album_meta_item">
									<?php echo '<span class="album_meta_title">'.strtoupper( __('Time: ', 'jamsession')).'</span>'.$event_time;?>
								</div>
							<?php
							}
						}
						
						if ( $event_location != "")
						{
						?>
							<div class="album_meta_item">
								<?php echo '<span class="album_meta_title">'.strtoupper( __('Location: ', 'jamsession')).'</span>'.$event_location;?>
							</div>
						<?php
						}						
						
						if ( $event_venue != "")
						{
						?>
							<div class="album_meta_item">
								<?php 
								echo '<span class="album_meta_title">'.strtoupper( __('Venue: ', 'jamsession')).'</span>';
								if ( $event_venue_url != "") 
								{
									echo '<a href="'.esc_url($event_venue_url).'" target="_blank" >';
								}
								echo $event_venue;
								if ( $event_venue_url != "") 
								{
									echo '</a>';
								}
								?>
							</div>
						<?php
						}

						echo '</div>';
					}

					
					if ( $event_buy_tickets_url != "") 
					{
						$buy_tickets_custom = "";
						if ( $event_buy_tickets_message != "")
						{
							$buy_tickets_custom = $event_buy_tickets_message;
						}
						else
						{
							$buy_tickets_custom = __("Buy Tickets", jamsession);							}
					?>
					<div class="custom_actions">
					<a href="<?php echo esc_url($event_buy_tickets_url); ?>" target="_blank"><?php echo $buy_tickets_custom; ?></a>
					</div>
					<?php
					}
					
					if ( $event_fb_url != "")
					{
					?>
					<div class="fb_actions">
					<a href="<?php echo esc_url($event_fb_url); ?>" target="_blank"><?php echo $event_fb_message; ?></a>
					</div>
					<?php
					}
					
					$event_map_url = trim($event_map_url);
					if ( $event_map_url != "")
					{
						echo '<div class="event_map">';
						/*backward compatibility*/
						if ( strpos($event_map_url, 'iframe') == false)
						{
							echo '<iframe frameborder="0" scrooling="no" marginheight="0" marginwidth="0" src="'.esc_url($event_map_url).'"></iframe>';
						}
						else
						{
							echo $event_map_url;
						}
						echo '</div>';
					}

					?>
			</div>
			
			<div id="event_listing">
				<?php 
					$album_title = get_the_title().'&ensp;'.'<span class="event_meta_date">'.date_i18n(get_option('date_format'), $dateObject->format('U')).'</span>';
					JAMSESSION_SWP_put_the_title("div", $album_title, "album_title", ""); 
				?>
				<div id="postmeta_custom">
				 <?php 
					$current_date_obj = new DateTime();
					$current_date_obj->setTimestamp(current_time('timestamp'));
					
					/*link to next or past event category*/
					$events = $dateObject >= $current_date_obj ? "next" : "past";
					$custom_taxonomy = 'event_category';
					if (has_term( '', $custom_taxonomy ))
					{ 
						$terms = get_the_terms(get_the_ID(), $custom_taxonomy);
						$count = count($terms);
						if (($count > 0) && ( !is_wp_error( $terms)))
						{
							$i = 0;
							$term_list = '<span class="post_cat">';
							foreach ($terms as $term) 
							{
								$i++;
								$new_url = add_query_arg( 'events', $events, get_term_link( $term ));
								$term_list .= '<a href="' . esc_url_raw($new_url) . '" title="' . sprintf(__('View all events filed under %s', 'jamsession'), $term->name) . '">' . $term->name . '</a>';
								
								if ($count != $i) 
								{
									$term_list .= ' ';
								}
							}
							$term_list .= '</span>';
							echo $term_list;
						}				
					}
				?> 
				</div>
				
				<div class="custom_content_audio">
				
				<?php 
					the_content(); 
					$protocol = is_ssl() ? 'https' : 'http';					
					
					$event_youtube_url  = esc_html( get_post_meta( get_the_ID(), 'event_youtube_url', true ) );	
					$event_vimeo_url  = esc_html( get_post_meta( get_the_ID(), 'event_vimeo_url', true ) );						
					
					if ( $event_youtube_url != "")
					{
						echo '<div class="eventPromo">';
						echo '<iframe type="text/html" src="'.$protocol.'://www.youtube.com/embed/'.JAMSESSION_SWP_getIDToEmbed(esc_url($event_youtube_url)).'?autoplay=0&amp;enablejsapi=1&amp;wmode=transparent" frameborder="0" allowfullscreen></iframe>';
						echo '</div>';
					}
					else
					{
						if ( $event_vimeo_url != "")
						{
							echo '<div class="eventPromo">';
							echo '<iframe  type="text/html" src="'.$protocol.'://player.vimeo.com/video/'.JAMSESSION_SWP_getIDToEmbed(esc_url($event_vimeo_url)).'?autoplay=0&amp;byline=0&amp;title=0&amp;portrait=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
							echo '</div>';
						}
					}
				?>
				<?php
					if(function_exists('the_post_thumbnail'))
					{
						$image_string =  wp_get_attachment_url(get_post_thumbnail_id());
					}
					JAMSESSION_SWP_add_social_sharing_icons(get_permalink(), get_the_title(), $image_string);
				?>				
				</div>
			</div>
			
			<div class="clearfix"></div>
			

	

		
		<?php comments_template();  ?>
	
	<?php 
		} /*while*/
	}	/*if*/
	else
	{
		?>
		<div id="post_content_container"> 
		<?php echo '<p>'.__('Sorry, no album matched your criteria.', 'jamsession').'</p>'; ?>
		</div>
		<?php
	}
	?>	



	<div class="clearfix"></div>
	
</div>
	

	

<?php	
	get_footer();
?>