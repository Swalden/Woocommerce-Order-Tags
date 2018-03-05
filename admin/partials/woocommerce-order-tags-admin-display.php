<?php $options = get_option( 'woocommerce_tags_settings' );
?>
<script>
    var removeSection = function (id) {
        jQuery(id).remove();
    };
    var newSection = function () {
        parent = jQuery('#woocommerceTagsContainer');
        var count = jQuery('.woocommerce_tags_section').length;
        console.log(count);
        count = parseInt(count) + 1;
        var newField = "<div id = 'tagGroup" + count + "'><span class = 'woocommerce_tags_section'>" +
            "<input type='text' name='woocommerce_tags_settings[woocommerce_tags_field][" + count + "][name]' value = ''>" +
            "<input type='hidden' name='woocommerce_tags_settings[woocommerce_tags_field][" + count + "][slug]' value = ''>" +
            "</span><button type = 'button' onclick = 'removeSection('#tagGroup'" + count + ");'>Remove Tag</button></div>";
        parent.append(newField);
        jQuery("#submit").click();
    };
</script>

<div id="woocommerceTagsContainer">
	<?php if( ! empty( $options[ woocommerce_tags_field ] ) ) {
		$customfields = $options[ woocommerce_tags_field ];
		$i            = 0;
		foreach( $customfields as $field ) { ?>
            <div id='tagGroup<?php echo $i; ?>'>
						<span class="woocommerce_tags_section">
						    <span>Title</span>
                            <input type='text'
                                   name='woocommerce_tags_settings[woocommerce_tags_field][<?php echo $i; ?>][name]'
                                   value='<?php echo $options['woocommerce_tags_field'][ $i ]['name']; ?>'>
                            <input type='hidden'
                                   name='woocommerce_tags_settings[woocommerce_tags_field][<?php echo $i; ?>][slug]'
                                   value='tags-<?php echo $i; ?>'>

					
					</span>
                <button type="button" onclick='removeSection("#tagGroup<?php echo $i; ?>")'>Remove Tag</button>
            </div>
			<?php $i ++;
		}
	} else { ?>
        <div id='tagGroup" + count + "'>
						<span id="fields" class="woocommerce_tags_section">
							<span>Title</span>
							<input type='text' name='woocommerce_tags_settings[woocommerce_tags_field][0][name]'>
							<input type='hidden' name='woocommerce_tags_settings[woocommerce_tags_field][0][slug]'
                                   value='tags-0'>

						</span>
            <button type="button" onclick='removeSection("#tagGroup<?php echo $i; ?>")'>Remove Tag</button>
        </div>

	<?php } ?>
    <button type="button" onclick='newSection()'>Add Tag</button>
</div>

			