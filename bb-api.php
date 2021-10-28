<?php
/*

Plugin Name: BB API Endpoint

Plugin URI: https://batterbasket.com/

Description: Dedicated for batterbasket

Version: 1.0.0

Author: Jadala barray

Author URI: https://automattic.com/wordpress-plugins/

*/
function get_products(){
//     $all_ids = get_posts( array(
//         'post_type' => 'product',
//         'numberposts' => -1,
//         'post_status' => 'publish'
//    ) );
//    $resString = count($all_ids);

   $data = [];
   $i = 0;
   $all_products = get_posts( array(
        'post_type' => 'product',
        'numberposts' => -1,
        'post_status' => 'publish'
    ) );

   foreach($all_products as $product){
        $product = wc_get_product( $product->ID);
        $data[$i]['id'] = $product->get_id();
        $data[$i]['name'] = $product->get_name();
        $data[$i]['price'] = get_woocommerce_currency_symbol().$product->get_price();
        $data[$i]['regular_price'] = get_woocommerce_currency_symbol().$product->get_regular_price();
        $data[$i]['sale_price'] = get_woocommerce_currency_symbol().$product->get_sale_price();
        $data[$i]['get_date_on_sale_from'] = ''.$product->get_date_on_sale_from();
        $data[$i]['get_date_on_sale_to'] = ''.$product->get_date_on_sale_to();

        $imgid = $product->get_image_id();
        $data[$i]['product_image'] = wp_get_attachment_image_url( $imgid, '' );
        // $product->get_name();
        // $product->get_slug();
        // $product->get_date_created();
        // $product->get_date_modified();
        // $product->get_status();
        // $product->get_featured();
        // $product->get_catalog_visibility();
        // $product->get_description();
        // $product->get_short_description();
        // $product->get_sku();
        // $product->get_menu_order();
        // $product->get_virtual();
       $i++; 
   }
    return $data ;
  //  return get_object_vars($all_ids[0]);
}

add_action('rest_api_init', function(){
    register_rest_route('bb/v1','products',[
        'methods' => 'GET',
        'callback' => 'get_products'    
    ]);
});

?>