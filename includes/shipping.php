<?php

/**
* @snippet Shipping by Weight | WooCommerce
* @how-to Watch tutorial @ https://businessbloomer.com/?p=19055
* @sourcecode https://businessbloomer.com/?p=21432
* @author Rodolfo Melogli / Alessio Pangos
* @testedwith WooCommerce 3.2.6
*/
 
add_filter( 'woocommerce_package_rates', 'bbloomer_woocommerce_tiered_shipping', 10, 2 );
   
function bbloomer_woocommerce_tiered_shipping( $rates, $package ) {
	global $woocommerce;
	$shipping_zone = WC_Shipping_Zones::get_zone_matching_package( $package );
 
    $zone = $shipping_zone->get_zone_id();

    // Sardegna
    if ($zone == 1) {
    	if ( WC()->cart->cart_contents_weight < 3 ) {
      
        if ( isset( $rates['flat_rate:1'] ) ) unset( $rates['flat_rate:8'], $rates['flat_rate:9'], $rates['flat_rate:10'], $rates['flat_rate:11'] );
       
	    } elseif ( WC()->cart->cart_contents_weight < 5 ) {
	       
	        if ( isset( $rates['flat_rate:1'] ) ) unset( $rates['flat_rate:1'], $rates['flat_rate:9'], $rates['flat_rate:10'], $rates['flat_rate:11'] );
	       
	    } elseif ( WC()->cart->cart_contents_weight < 10 ) {
	       
	        if ( isset( $rates['flat_rate:1'] ) ) unset( $rates['flat_rate:1'], $rates['flat_rate:8'], $rates['flat_rate:10'], $rates['flat_rate:11'] );
	       
	    } elseif ( WC()->cart->cart_contents_weight < 20 ) {
	       
	        if ( isset( $rates['flat_rate:1'] ) ) unset( $rates['flat_rate:1'], $rates['flat_rate:8'], $rates['flat_rate:9'], $rates['flat_rate:11'] );
	       
	    } elseif ( WC()->cart->cart_contents_weight < 40 ) {
	       
	        if ( isset( $rates['flat_rate:1'] ) ) unset( $rates['flat_rate:1'], $rates['flat_rate:8'], $rates['flat_rate:9'], $rates['flat_rate:10'] );
	       
	    }
    } else if ($zone == 2) { // Calabria / Sicilia
    	if ( WC()->cart->cart_contents_weight < 3 ) {
      
        if ( isset( $rates['flat_rate:3'] ) ) unset( $rates['flat_rate:4'], $rates['flat_rate:5'], $rates['flat_rate:6'], $rates['flat_rate:7'] );
       
	    } elseif ( WC()->cart->cart_contents_weight < 5 ) {
	       
	        if ( isset( $rates['flat_rate:3'] ) ) unset( $rates['flat_rate:3'], $rates['flat_rate:5'], $rates['flat_rate:6'], $rates['flat_rate:7'] );
	       
	    } elseif ( WC()->cart->cart_contents_weight < 10 ) {
	       
	        if ( isset( $rates['flat_rate:3'] ) ) unset( $rates['flat_rate:3'], $rates['flat_rate:4'], $rates['flat_rate:6'], $rates['flat_rate:7'] );
	       
	    } elseif ( WC()->cart->cart_contents_weight < 20 ) {
	       
	        if ( isset( $rates['flat_rate:3'] ) ) unset( $rates['flat_rate:3'], $rates['flat_rate:4'], $rates['flat_rate:5'], $rates['flat_rate:7'] );
	       
	    } elseif ( WC()->cart->cart_contents_weight < 40 ) {
	       
	        if ( isset( $rates['flat_rate:3'] ) ) unset( $rates['flat_rate:3'], $rates['flat_rate:4'], $rates['flat_rate:5'], $rates['flat_rate:6'] );
	       
	    }
    } else if ($zone == 3) { // resto d'Italia
    	if ( WC()->cart->cart_contents_weight < 3 ) {
      
        if ( isset( $rates['flat_rate:12'] ) ) unset( $rates['flat_rate:13'], $rates['flat_rate:14'], $rates['flat_rate:15'], $rates['flat_rate:16'] );
       
	    } elseif ( WC()->cart->cart_contents_weight < 5 ) {
	       
	        if ( isset( $rates['flat_rate:12'] ) ) unset( $rates['flat_rate:12'], $rates['flat_rate:14'], $rates['flat_rate:15'], $rates['flat_rate:16'] );
	       
	    } elseif ( WC()->cart->cart_contents_weight < 10 ) {
	       
	        if ( isset( $rates['flat_rate:12'] ) ) unset( $rates['flat_rate:12'], $rates['flat_rate:13'], $rates['flat_rate:15'], $rates['flat_rate:16'] );
	       
	    } elseif ( WC()->cart->cart_contents_weight < 20 ) {
	       
	        if ( isset( $rates['flat_rate:12'] ) ) unset( $rates['flat_rate:12'], $rates['flat_rate:13'], $rates['flat_rate:14'], $rates['flat_rate:16'] );
	       
	    } elseif ( WC()->cart->cart_contents_weight < 40 ) {
	       
	        if ( isset( $rates['flat_rate:12'] ) ) unset( $rates['flat_rate:12'], $rates['flat_rate:13'], $rates['flat_rate:14'], $rates['flat_rate:15'] );
	       
	    } else {
	    	$rates = array();
	    }
    }

   
    return $rates;
   
}