<?php
/*
Plugin Name: Wordpress Twitter Forums
Plugin URI: http://www.StevenMilanese.com/wordpress-twitter-forums/
Description: Adds a floating "Twitter Forums" button to the right-hand side of your WordPress Blog, that slides a Retweet.@ powered forum into view when users click on it.
Author: Steven Milanese
Version: 2.1
Author URI: http://www.StevenMilanese.com/
*/
/*  Copyright 2010 Steven Milanese (email: support at stevenmilanese.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

require_once( ABSPATH . '/wp-includes/functions.php' );
require_once( ABSPATH . '/wp-includes/plugin.php' );

function retweet_style()
{
	// this is where we'll style our button
	echo
	'<style type=\'text/css\'>
div.floating-menu {position:fixed; right: 0; background:transparent; width:75px; margin-top:130px;z-index:100;}
div.floating-menu a, div.floating-menu h3 {display:block; margin:0 0.5em;}
</style>';
}


function retweet(){
    
	?>
    	<div class="floating-menu">
<a href="javascript:(function(){_smtn_embed_version=1;_smtn_embed_base='http://retweet.at';_smtn_script=document.createElement('script');_smtn_script.type='text/javascript';_smtn_script.src='http://retweet.at/js/embed.js';document.getElementsByTagName('head')[0].appendChild(_smtn_script);})();"><img src="/wp-content/plugins/wordpress-twitter-forums-plugin/images/retweet.png"></a>
</div>
    <?php
}

add_action('admin_menu', 'retweet_options');

function retweet_options() {
	add_menu_page('Retweet&#46;&#64;', 'Retweet&#46;&#64;', 8, basename(__FILE__), 'retweet_options_page');
	add_submenu_page(basename(__FILE__), 'Settings', 'Settings', 8, basename(__FILE__), 'retweet_options_page');
}

function retweet_activate() {
	$default_settings = Array(
		'button_position' => 'deactivated',
		'page_display' => 0,
		'button_style' => 'float: left; margin-right: 10px; margin-top: 0px;'
	);

	if (!is_array(get_option('RetweetButton'))) {			
		add_option('RetweetButton', $default_settings);
	}
}

function retweet_deactivate() {
	if (is_array(get_option('RetweetButton'))) {			
		delete_option('RetweetButton');
	}
}

function retweet_options_page() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

	if ($_POST['retweet_embed'] == 'save') {
		$new_options['button_position'] = $_POST['button_position'];
		$new_options['page_display'] = $_POST['page_display'];
		$new_options['button_style'] = $_POST['button_style'];

		update_option('RetweetButton', $new_options);
		echo '<div class="wrap updated fade" id="message" style="margin-top:20px;"><p>'.__('New settings saved','retweet-saved').'</p></div>';
	}

	$config = get_option('RetweetButton');

	?>
	<div class="wrap" style="background-color:#ecf6fa; padding:0 0 0 10px; ">
<div id="icon-edit" class="icon32"></div><h2><a href="http://retweet.at" target="_blank" title="Retweet">Retweet&#46;&#64;</a> Powered Wordpress Twitter Forums v2&#46;0</h2><hr/><h4>&copy;Copyright 2010 <a href="http://www.stevenmilanese.com" target="_blank">Steven Milanese</a> &#40;email: <a href="mailto:support@stevenmilanese.com">support at stevenmilanese.com</a>&#41;</h4><img src ="http://www.stevenmilanese.com/wp-content/themes/nerdcore/images/plugins/retweet-expanded-view.png" align="left" height="125px" width="175px" style="margin:0 10px 10px 0"/>The WordPress Twitter Forums Plugin places a unique floating Twitter Forums button on the right edge of your WordPress Blog that expands with a animated slide&#45;in effect to reveal a Retweet&#46;&#64; Twitter powered forum&#46; Retweet&#46;&#64; is a free service developed and provided by SumtnSumtn UG &#40;haftungsbeschr&#352;nkt&#41;&#46; This plugin takes advantage of this powerful social media resource and incorporates it into your WordPress website in a unique way that allows you to create an ongoing conversation users, engaging them interactively with your website&#39;s content&#46; There is no additional configuration needed for this portion of the plugin&#46;<br/><br/>
New in version 2.0 is the ability to add an <a hreh="http://twitter.com/goodies/tweetbutton" target="_blank" title="Official Twitter Button Source Page">OFFICIAL Twitter button</a> to your content and&#47;or pages&#46; These settings can be configured in the panel below.<br/><br/>If you are in need of support or would like to make a feature request for future releases, you may leave a comment on the <a href="http://www.stevenmilanese.com/wordpress/plugin-development/wordpress-twitter-forums/" target="_blank">Official Plugin Page</a> or contact me via email at <a href="mailto:support@stevenmilanese.com">support at stevenmilanese.com</a><br/><br/><strong>Support the Wordpress Twitter Forums Plugin</strong><br/>If you find this plugin useful please consider making a donation to the plugin's developer&#46;<br/><br/>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="KG6KGHUYG7VKA">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
<br/><br/>
<div id="icon-plugins" class="icon32"></div><h2><?php _e('Retweet.&#64; Additional Content Button','retweet-button-config'); ?></h2><hr/>This portion of the plugin is <strong>OPTIONAL</strong> and is offered in addition to the <a href="http://www.retweet.at" target="_blank" title="Retweet.&#64;">Retweet&#46;&#64;</a> Forums&#46; Add this button to your website to let people share content on Twitter without having to leave the page. Promote strategic Twitter accounts at the same time while driving traffic to your website&#46;<br/><br/>
		<form action="" method="post" class="retweet_data" name="retweet_data" id="retweet_data">
			<input type="hidden" id="retweet_embed" name="retweet_embed" value="save" />
			<table class="widefat" style="width: 90%;">
				<thead>
					<tr>
						<th scope="col" style="width: 30%"><?php _e('Retweet Button Options','retweet-options-hd'); ?></th>
						<th scope="col"><?php _e('Settings','retweet-settings-hd'); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><strong><?php _e('Display Retweet button in posts&#63;','retweet-button-position'); ?></strong></td>
						<td>
							<select name="button_position" id="button_position">
								<option value="deactivated" <?php if($config['button_position'] == 'Deactivated') { echo 'selected="selected"'; } ?>><?php _e('Retweet Button Deactivated','retweet-deactivated'); ?></option>
								<option value="top" <?php if($config['button_position'] == 'top') { echo 'selected="selected"'; } ?>><?php _e('Insert Retweet button before the content','retweet-before-content'); ?></option>
								<option value="after" <?php if($config['button_position'] == 'after') { echo 'selected="selected"'; } ?>><?php _e('Insert Retweet button after the content','retweet-after-content'); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td><strong><?php _e('Display Retweet button on pages&#63;','button-display-page'); ?></strong></td>
						<td>
							<select name="page_display" id="page_display">
								<option value="0" <?php if($config['page_display'] == '0') { echo 'selected="selected"'; } ?>><?php _e('Deactivate Retweet button on pages','retweet-no'); ?></option>
								<option value="1" <?php if($config['page_display'] == '1') { echo 'selected="selected"'; } ?>><?php _e('Activate Retweet button on pages','retweet-yes'); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td><strong><?php _e('Here you can add additional styles to the &#60;<code>DIV</code> &#62; element surrounding Retweet&rsquo;s button. Do not define classes, use only CSS styling. Your styling will be used inline.','retweet-additional-style'); ?></strong></td>
						<td>
							<p><textarea class="button_style" id="button_style" name="button_style" cols="30" rows="3" style="width: 350px;"><?php if (isset($config['button_style'])) { echo htmlspecialchars($config['button_style']); } ?></textarea></p>
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit" style="border: none; margin: 0 0 20px 0; width: 90%;"><input type="submit" value="<?php _e('Apply settings','retweet-apply-settings'); ?>" name="retweet_save" /></p>
		</form>
</div>
<?php
}

function tweet_button($content) {
	global $post;
	$config = get_option('RetweetButton');
	$permalink = get_permalink($post->ID);
	$post_title = get_the_title($post->ID);
	$position = $config['button_position'];
	$button_style = $config['button_style'];
	$retweetbutton = '<a href="javascript:(function(){_smtn_embed_version=1;_smtn_embed_base=\'http://retweet.at\';_smtn_script=document.createElement(\'script\');_smtn_script.type=\'text/javascript\';_smtn_script.src=\'http://retweet.at/js/embed.js\';document.getElementsByTagName(\'head\')[0].appendChild(_smtn_script);})();"><img src="/wp-content/plugins/wordpress-twitter-forums-plugin/images/rt_button.png"></a>';

	$tweet_button = '<div style="'.$button_style.'">'.$retweetbutton.'</div>';
	if ($position == '' or $position == 'top') {
		$content = $tweet_button . $content;
	}
	else if ($position == 'after') {
		$content = $content . $tweet_button;
	}
	else if ($position == 'deactivated') {
		$content = $content;
	}
	return $content;
}

function retweet_it($content) {
	global $post;
	$config = get_option('RetweetButton');

	if(is_page()) {
		if($config['page_display'] == 0) {
			return $content;
		}
		else if ($config['page_display'] == 1) {
			$content = tweet_button($content);
			return $content;
		}
	}

	else {
		$content = tweet_button($content);
		return $content;
	}
}

add_action('wp_head', 'retweet_style');
add_action('wp_head', 'retweet');
add_filter ('the_content', 'retweet_it');
register_activation_hook( __FILE__, 'retweet_activate');
register_deactivation_hook( __FILE__, 'retweet_deactivate');
?>