<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<label>
		<input type="search" class="search-field" placeholder="<?php echo __('Search for ...', 'jamsession'); ?>" value="" name="s" title="<?php echo __('Search for:', 'jamsession'); ?>" />
	</label>
	<input type="submit" class="search-submit" value="<?php echo __("Search", "jamsession"); ?>" />
</form>
