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
			<div id="album_cover"> 
				<?php
						/*get the thumbnail */
						the_post_thumbnail('full');
					
						$album_buy_message1 = esc_html( get_post_meta( get_the_ID(), 'album_buy_message1', true ) ); 			
						$album_buy_link1 = esc_html( get_post_meta( get_the_ID(), 'album_buy_link1', true ) ); 			
	
						$album_buy_message2 = esc_html( get_post_meta( get_the_ID(), 'album_buy_message2', true ) ); 			
						$album_buy_link2 = esc_html( get_post_meta( get_the_ID(), 'album_buy_link2', true ) ); 			

						$album_buy_message3 = esc_html( get_post_meta( get_the_ID(), 'album_buy_message3', true ) ); 			
						$album_buy_link3 = esc_html( get_post_meta( get_the_ID(), 'album_buy_link3', true ) );
						
						$album_buy_message4 = esc_html( get_post_meta( get_the_ID(), 'album_buy_message4', true ) ); 			
						$album_buy_link4 = esc_html( get_post_meta( get_the_ID(), 'album_buy_link4', true ) );
						
						$album_buy_message5 = esc_html( get_post_meta( get_the_ID(), 'album_buy_message5', true ) ); 			
						$album_buy_link5 = esc_html( get_post_meta( get_the_ID(), 'album_buy_link5', true ) );
						
						$album_buy_message6 = esc_html( get_post_meta( get_the_ID(), 'album_buy_message6', true ) ); 			
						$album_buy_link6 = esc_html( get_post_meta( get_the_ID(), 'album_buy_link6', true ) );
						
						if ( $album_buy_message1 != "") 
						{ 
						?>
						<div class="custom_actions">
						<a href="<?php echo esc_url($album_buy_link1); ?>" target="_blank"><?php echo $album_buy_message1; ?></a>
						</div>
						<?php
						}
						if ( $album_buy_message2 != "")
						{
						?>
						<div class="custom_actions">
						<a href="<?php echo esc_url($album_buy_link2); ?>" target="_blank"><?php echo $album_buy_message2; ?></a>
						</div>
						<?php
						}
						if ( $album_buy_message3 != "")
						{
						?>
						<div class="custom_actions">
						<a href="<?php echo esc_url($album_buy_link3); ?>" target="_blank"><?php echo $album_buy_message3; ?></a>
						</div>
						<?php
						}
						if ( $album_buy_message4 != "")
						{
						?>
						<div class="custom_actions">
						<a href="<?php echo esc_url($album_buy_link4); ?>" target="_blank"><?php echo $album_buy_message4; ?></a>
						</div>
						<?php
						}
						if ( $album_buy_message5 != "")
						{
						?>
						<div class="custom_actions">
						<a href="<?php echo esc_url($album_buy_link5); ?>" target="_blank"><?php echo $album_buy_message5; ?></a>
						</div>
						<?php
						}
						if ( $album_buy_message6 != "")
						{
						?>
						<div class="custom_actions">
						<a href="<?php echo esc_url($album_buy_link6); ?>" target="_blank"><?php echo $album_buy_message6; ?></a>
						</div>
						<?php
						}
						
						$album_artist = esc_html( get_post_meta( get_the_ID(), 'album_artist', true ) );
						$album_release_date = esc_html( get_post_meta( get_the_ID(), 'album_release_date', true ) );
						$album_no_disc = esc_html( get_post_meta( get_the_ID(), 'album_no_disc', true ) ); 
						$album_label = esc_html( get_post_meta( get_the_ID(), 'album_label', true ) ); 	
						$album_producer	= esc_html( get_post_meta( get_the_ID(), 'album_producer', true ) ); 
						$album_cat_no	= esc_html( get_post_meta( get_the_ID(), 'album_catalogue_number', true ) ); 
						
						@$album_release_date = str_replace("/","-", $album_release_date);
						try {
							@$mydate = new DateTime($album_release_date);	
						} catch(Exception $e) {
							@$mydate = new DateTime('NOW');
						}
						 
						if ( ($album_release_date != "") || ($album_no_disc != "") || ( $album_label != "") || ($album_producer != "") || ($album_artist != "") 
							|| $album_cat_no != "")
						{
							echo '<div class="album_meta">';
							if ( $album_release_date != "")
							{
							?>
								<div class="album_meta_item">
								<?php echo '<span class="album_meta_title">'.strtoupper( __('Released: ', 'jamsession')).'</span>'.date_i18n(get_option('date_format'), $mydate->format('U'));?>
								</div>
							<?php
							}
							if ( $album_artist != "")
							{
							?>
								<div class="album_meta_item">
								<?php echo '<span class="album_meta_title">'.strtoupper( __('Artist: ', 'jamsession')).'</span>'.$album_artist;?>
								</div>
							<?php
							}
							if ( $album_label != "")
							{
							?>
								<div class="album_meta_item">
								<?php echo '<span class="album_meta_title">'.strtoupper( __('Label: ', 'jamsession')).'</span>'.$album_label;?>
								</div>
							<?php
							}
							if ( $album_producer != "")
							{
							?>
								<div class="album_meta_item">
								<?php echo '<span class="album_meta_title">'.strtoupper( __('Producer: ', 'jamsession')).'</span>'.$album_producer;?>
								</div>
							<?php
							}
							if ( $album_cat_no != "")
							{
							?>
								<div class="album_meta_item">
								<?php echo '<span class="album_meta_title">'.strtoupper( __('Catalogue Number: ', 'jamsession')).'</span>'.$album_cat_no;?>
								</div>
							<?php
							}
							if ( $album_no_disc != "")
							{
							?>
								<div class="album_meta_item">
								<?php echo '<span class="album_meta_title">'.strtoupper( __('Number of Discs: ', 'jamsession')).'</span>'.$album_no_disc;?>
								</div>
							<?php
							}
							
							echo '</div>';
						}
						?>
			</div>
			
			<div id="album_listing">
				<?php JAMSESSION_SWP_put_the_title("div", get_the_title(), "album_title", ""); ?>
				<div id="postmeta_custom">
				 <?php 
					// the_date('F j, Y'); 
					
					if (has_term( '', 'album_category' ))
					{ 
						echo ' <span class="post_cat">'; the_terms( get_the_ID(), 'album_category', '', ' ' ); echo "</span>"; 
					}
				?> 
				</div>
				<?php
				$album_SC =  get_post_meta( get_the_ID(), 'album_SC', true );
				if ( $album_SC != "")
				{
						/*show soundcloud*/
						$allowed_html = array(
											'iframe' => array(
												'width' => array(),
												'height' => array(),
												'scrolling' => array(),
												'frameborder' => array(),
												'src' => array()
											)
										);
						echo wp_kses($album_SC, $allowed_html);
				}
				else
				{
					/*mp3 list*/
					$tracks = get_attached_media( 'audio', get_the_ID() );
					$track_order = 1;
					foreach ($tracks as $track)
					{
						echo '<div class="single_track">';
						echo $track_order.". ".$track->post_title."<br>";
					
						$attr = array(
							'src'      => wp_get_attachment_url($track->ID),
							'loop'     => '',
							'autoplay' => '',
							'preload' => 'none'
						);
						echo wp_audio_shortcode( $attr );
						echo '</div>';
						$track_order++;
					}
				}
				?>
				
				<div class="custom_content_audio">
				<?php 
				
					$videoCssClass = "albumPromo alignright";
					if ( !get_the_content()) {
						$videoCssClass = "albumPromo alignleft";
					}
					
				
					$album_youtube = esc_html( get_post_meta( get_the_ID(), 'album_youtube', true ) ); 			
					$album_vimeo = esc_html( get_post_meta( get_the_ID(), 'album_vimeo', true ) );
					$website_protocol = is_ssl() ? 'https' : 'http';
					
					if ( $album_youtube != "")
					{
						echo '<div class="'.$videoCssClass.'">';
						echo '<iframe type="text/html" src="'.$website_protocol.'://www.youtube.com/embed/'.JAMSESSION_SWP_getIDToEmbed(esc_url($album_youtube)).'?autoplay=0&amp;enablejsapi=1&amp;wmode=transparent" frameborder="0" allowfullscreen></iframe>';
						echo '</div>';
					}
					else
					{
						if ( $album_vimeo != "")
						{
							echo '<div class="'.$videoCssClass.'">';
							echo '<iframe  type="text/html" src="'.$website_protocol.'://player.vimeo.com/video/'.JAMSESSION_SWP_getIDToEmbed(esc_url($album_vimeo)).'?autoplay=0&amp;byline=0&amp;title=0&amp;portrait=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
							echo '</div>';
						}
					}
						the_content(); 

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