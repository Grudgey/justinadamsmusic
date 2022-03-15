<?php
	get_header();
?>
	
<div id="main_content">
	
	
	<?php
	
	if (have_posts()) {	
		while (have_posts()) {
			
			the_post();
			
			JAMSESSION_SWP_put_the_title("div", get_the_title(), "post_title", ""); 
	?>
			
			<div id="postmeta_custom">
			<?php
			JAMSESSION_SWP_put_single_post_meta();
			
			if ( has_term( '', 'photo_album_category' ))
			{ 
				echo ' <span class="post_cat">'; 
				the_terms( $post->ID, 'photo_album_category', '', ' ' );
				echo "</span>"; 
			}
			?> 
			</div>
			<div id="post_content_container"> <?php
				$js_swp_gallery_images = esc_html(get_post_meta(get_the_ID(), 'js_swp_gallery_images', true));
				$js_swp_gallery_images_id = esc_html(get_post_meta(get_the_ID(), 'js_swp_gallery_images_id', true));
				/*compatibility reasons - with versions smaller than 2.4.2*/				
				$js_swp_gallery_compatibility242 = esc_html(get_post_meta(get_the_ID(), 'js_swp_gallery_compatibility242', true));
				$js_swp_gallery_compatibility243 = esc_html(get_post_meta(get_the_ID(), 'js_swp_gallery_compatibility243', true));
				
				$galleryImages = array();
				/*compatibility with older versions < 2.4.2*/
				if (('' == trim($js_swp_gallery_images)) && ('' == $js_swp_gallery_compatibility242)) {
					/* get the image from attachments*/
					$args = array(
						'post_type' => 'attachment',
						'numberposts' => -1,
						'post_status' => null,
						'post_parent' => $post->ID,
						'order'             => 'ASC',
						'orderby'           => 'menu_order'						
					);
					$attachments = get_posts( $args );
					if ($attachments ) {
						foreach ($attachments as $attachment) {
							$singleObj = array();
							$singleObj['caption'] =  $attachment->post_excerpt;
							$singleObj['href'] 	= wp_get_attachment_url($attachment->ID);
							$singleObj['image'] 	= wp_get_attachment_image( $attachment->ID, 'medium' );
							
							$galleryImages[] = $singleObj;
						}
					}
				} else {
					/*1st functionality update*/
					if (('' == $js_swp_gallery_compatibility243) && ('' == trim($js_swp_gallery_images_id))) {
						$imagesFromInput = explode(",", $js_swp_gallery_images);
						foreach($imagesFromInput as $inputEntry) {
							$singleObj = array();
							/*remove [ and ] at the beginning and end of the string*/
							$singleObj['href'] 	= substr($inputEntry, 1, -1);
							$attachmentID = JAMSESSION_SWP_get_attachment_id_from_url($singleObj['href']);
							if (!$attachmentID) {
								$singleObj['caption'] = '';
								$singleObj['image'] = '<img src='.$singleObj['href'].'>';
							} else {
								$attachObj = get_post($attachmentID);
								$singleObj['caption'] =  $attachObj->post_excerpt;
								$singleObj['image'] 	= wp_get_attachment_image( $attachmentID, 'medium' );						
							}
							
							$galleryImages[] = $singleObj;
						}
					} else {
						/*current functionality*/
						$idsArray = explode(',', $js_swp_gallery_images_id);
						$idsArray = array_filter($idsArray);
						if (!empty($idsArray)) {
							foreach($idsArray as $imgId) {
								$singleObj = array();
								
								$attachObj = get_post($imgId);
								$singleObj['caption'] =  $attachObj->post_excerpt;
								if ($imageSrc = wp_get_attachment_image_src($imgId, 'full')) {
									$singleObj['href'] = $imageSrc[0];
								} else {
									$singleObj['href'] = '';
								}
								$singleObj['image']	= wp_get_attachment_image( $imgId, 'medium');
								
								$galleryImages[] = $singleObj;
							}
						}
					}
				}
				
				
				if (!empty($galleryImages)) {
					foreach ($galleryImages as $imageObj ) 
					{
						$caption = $imageObj['caption'];
						$dtitle = '';
						if ($caption) {
							$dtitle = 'data-title="'.$caption.'" ';
						}
						
						?>
						<div class="post_item_gallery" >
							<a href="<?php echo $imageObj['href']; ?>" data-lightbox="photo_album" <?php echo $dtitle; ?> >
								<div class="post_image_container">
									<div class="post_icon_more">
										<i class="icon-picture"></i> 
									</div>
									<div class="post_fader"></div>
									<?php
									echo $imageObj['image'];
									?>
								</div>
							</a>
						</div>	
						<?php
					}
				}
				
				
				?>
				<div id="content_loader"></div>
			</div>
	

		<div class="custom_content">
		<?php the_content(); ?>
		</div>
		
		<?php
			if(function_exists('the_post_thumbnail'))
			{
				$image_string =  wp_get_attachment_url(get_post_thumbnail_id());
			}
			JAMSESSION_SWP_add_social_sharing_icons(get_permalink(), get_the_title(), $image_string);
		?>		
		<?php comments_template();  ?>
	
	<?php 
		} /*while*/
	}	/*if*/
	else
	{
		?>
		<div id="post_content_container"> 
		<?php echo '<p>'.__('Sorry, no photo albums matched your criteria.', 'jamsession').'</p>'; ?>
		</div>
		<?php
	}
	?>	
		
	</div>


	<div class="clearfix"></div>
	
</div>
	

	

<?php	
	get_footer();
?>