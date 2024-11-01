<?php

//Plugin Name: Tweet It!
//Description: Plugin to Tweet specific lines of text. Simply add the shortcode [tweetit] [/tweetit] around your text directly from your WordPress posts. This plugin is Michael Jackson approved. Tweet It, just Tweet It!
// Author: Sam Kirtley
// Author URI: http://samkirtley.com
//Version: 1.0

add_action( 'init', 'tweetit_init' );
add_action('admin_menu', 'tweetit_settings');
add_shortcode( 'tweetit', 'tweetit_shortcode' );

function tweetit_init() {
    wp_enqueue_style( 'adfero-tweetit-style', plugins_url('resources/tweetit-style.css', __FILE__) );
    wp_enqueue_script( 'adfero-tweetit-script', plugins_url('resources/tweetit-script.js', __FILE__), array( 'jquery' ) );
    wp_enqueue_script( 'addthis', 'http://s7.addthis.com/js/250/addthis_widget.js' );
}

function tweetit_settings() {
    add_menu_page('Tweet It! Settings', 'Tweet It! Settings', 'administrator', 'tweetit_settings', 'tweetit_display_settings', plugin_dir_url(__FILE__).'resources/moonwalk.png');
}

function tweetit_display_settings() {

    $addthis_pubid = (get_option('addthis_pubid') != '') ? get_option('addthis_pubid') : '';

    $bitly_username = (get_option('bitly_username') != '') ? get_option('bitly_username') : '';

    $bitly_api_key = (get_option('bitly_api_key') != '') ? get_option('bitly_api_key') : '';

    $html = '</pre>
<div class="wrap"><form action="options.php" method="post" name="options">
<h2>Enter Your Settings</h2>
<h4>*Both Bitly fields required for custom URLs</h4>
' . wp_nonce_field('update-options') . '
<table class="form-table" width="100%" cellpadding="10">
<tbody>
<tr>
<td scope="row" align="left">
<label>AddThis Public ID: </label><input type="text" name="addthis_pubid" value="' . $addthis_pubid . '" /></td>
</tr>
<tr>
<td scope="row" align="left">
<label>Bitly User Name: </label><input type="text" name="bitly_username" value="' . $bitly_username . '" /></td>
</tr>
<tr>
<td scope="row" align="left">
<label>Bitly API Key: </label><input type="text" name="bitly_api_key" value="' . $bitly_api_key . '" /></td>
</tr>
</tbody>
</table>
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="addthis_pubid,bitly_username,bitly_api_key" />
<input type="submit" name="Submit" value="Update" /></form></div>
<pre>
';

    echo $html;

}

function tweetit_shortcode( $atts, $content = null ){
	$permalink = get_permalink( $id );
    return '<a class="custom-addthis-custom tweetit" href="http://api.addthis.com/oexchange/0.8/forward/twitter/offer?url='
     . $permalink . '&text=' . strip_tags($content) . '&pubid=' . get_option( 'addthis_pubid', '' ) . '&shortener=bitly&bitly.login=' 
     . get_option( 'bitly_username', '' ) . '&bitly.apiKey=' . get_option( 'bitly_api_key', '' ) . '">' . $content . ' <span class="tweet-bird"></span></a>';
}