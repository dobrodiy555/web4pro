<?php
/*
Plugin Name:  task3_plugin
Description:  This plugin displays shops on Google Map.
Version:      1.0
Author:       Andrei Miheev
License:      GPL2
*/

register_activation_hook( __FILE__, 'tp3_plugin_activate' );
register_deactivation_hook( __FILE__, 'tp3_plugin_deactivate' );
add_action( 'init', 'tp3_create_post_type' );
add_action( 'admin_menu', "tp3_add_meta_box" );
add_action( 'save_post', 'tp3_save_meta_box_data', 10, 2 ); 
add_shortcode('show_map_with_address', 'tp3_show_map_with_address');

function tp3_create_post_type() {
	register_post_type('shops',
		array(
			'labels' => array(
				'name' => __( 'Shops' ),
				'singular_name' => __( 'Shop' )
		),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'shops'),
			'show_in_rest' => true,
		)
	);
}

function tp3_plugin_activate() {
	tp3_create_post_type();
	flush_rewrite_rules();
}

function tp3_plugin_deactivate() {
	unregister_post_type( 'shops');
	flush_rewrite_rules();
}

// creating custom fields for 'shops' post type
function tp3_add_meta_box() {
	add_meta_box(
		'tp3_meta_box',
		'Tp3 Meta Box',
		'tp3_build_meta_box',
		'shops',
		'normal',
		'default'
	);
}

function tp3_build_meta_box( $post ) {
	$shop_name = get_post_meta ( $post->ID, 'shop_name', true );
	$shop_description = get_post_meta ( $post->ID, 'shop_description', true );
	$shop_address = get_post_meta ( $post->ID, 'shop_address', true );
	wp_nonce_field( 'somerandomstr', '_andreinonce' );
	?>
	<p>
		<label for="shop_name"> <?php _e("Shop name:"); ?> </label>
		<input type="text" name="shop_name" value="<?php echo esc_attr( $shop_name ); ?>" />
	</p>
	<p>
		<label for="shop_description"> <?php _e("Shop description:"); ?> </label>
		<input name="shop_description" type="text" value="<?php echo esc_attr( $shop_description ); ?>" />
	</p>
	<p>
		<label for="shop_address"> <?php _e("Shop address:"); ?> </label>
		<input name="shop_address" type="text" value="<?php echo esc_attr( $shop_address ); ?>" />
	</p>
<?php
}

function tp3_save_meta_box_data ( $post_id, $post ) {
	if ( ! isset( $_POST[ '_andreinonce' ] ) || ! wp_verify_nonce( $_POST[ '_andreinonce'], 'somerandomstr' ) ) {
		return $post_id;
    }

    $post_type = get_post_type_object ( $post->post_type );
	if ( ! current_user_can ( $post_type->cap->edit_post, $post_id ) ) {
		return $post_id;
	}

    if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return $post_id;
    }

    if( isset( $_POST[ 'shop_name' ] ) ) {
        update_post_meta( $post_id, 'shop_name', sanitize_text_field( $_POST[ 'shop_name' ] ) );
    } else {
        delete_post_meta( $post_id, 'shop_name' );
    }

	if( isset( $_POST[ 'shop_description' ] ) ) {
		update_post_meta( $post_id, 'shop_description', sanitize_text_field( $_POST[ 'shop_description' ] ) );
	} else {
		delete_post_meta( $post_id, 'shop_description' );
	}

    if( isset( $_POST['shop_address'] ) ) {
	    update_post_meta( $post_id, 'shop_address', sanitize_text_field( $_POST['shop_address'] ) );
    } else {
        delete_post_meta( $post_id, 'shop_address' );
    }
    return $post_id;
}

function tp3_show_map_with_address () {
    $shop_name = get_post_meta ( get_the_ID(), 'shop_name', true );
	$shop_address = get_post_meta ( get_the_ID(), 'shop_address', true );
	ob_start();
	?>
    <body onload="buildMap()">
    <p>Shop on map: </p>
    <div id="map" style="width:320px;height:480px"></div>
    <div>
        <span id="address" value="<?php echo $shop_address; ?>"><?php echo $shop_address; ?></span>
    </div>
    <script>
        function buildMap() {
            var geocoder;
            var map;
            geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(50, 30);
            var mapOptions = {
                zoom: 15,
                center: latlng
            }
            map = new google.maps.Map(document.getElementById('map'), mapOptions);
            var address = "<?php echo $shop_address ?>"; 
            geocoder.geocode({ 'address': address }, function (results, status) {
                if (status == 'OK') {
                    map.setCenter(results[0].geometry.location);
                    var content = "<h3><?php echo $shop_name;?></h3>" +
                    "<p><?php echo $shop_address;?></p>"; // content of infobox 
                    var infoWindow = new google.maps.InfoWindow({
                        content: content,
                    });
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                    marker.addListener('click', function() {
                        infoWindow.open({
                            anchor: marker,
                            map,
                        });
                    });
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }
    </script>
    <script
            src="https://maps.googleapis.com/maps/api/js?key={myKey}&callback=initMap"> 
    </script>
    </body>
	<?php
	return ob_get_clean();
}







