<?php
/*
Plugin Name: World Flag
Version: 2.5
Author: WPPress.net
Author URI: http://wppress.net/
Plugin URI: https://wordpress.org/plugins/world-flag
Description:  Add any World's Country flag to post or page

License: GPL2
Copyright (C) 2013, Sovit Tamrakar

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/
class WorldFlag
{
	private $pluginDir = "";
	private $ar_countries = array();
	function __construct()
	{
		global $wpdb;
		global $ar_countries;
		$this->ar_countries = $ar_countries;
		$this->pluginDir    = $wpdb->worldflag_plugin_dir = plugin_dir_url(__FILE__);
		add_action('init', array(
			&$this,
			'init'
		));
		add_action('admin_init', array(
			&$this,
			'admin_init'
		));
		add_action('wp_enqueue_scripts', array(
			&$this,
			'wp_enqueue_scripts'
		));
		add_shortcode('flag', array(
			&$this,
			'shortcode'
		));
		add_filter('tiny_mce_version', array(
			&$this,
			'my_refresh_mce'
		));
		add_filter('wp_ajax_wppress_worldflag_dialog', array(
			&$this,
			'worldflag_dialog'
		));
		$this->ar_countries=include('countries.php');
	}
	function admin_init()
	{
		$this->add_tinymce_buttons();
		add_editor_style($this->pluginDir . 'assets/flags.css');
	}
	function init()
	{
		// More Stuffs should be coming here.
	}
	function my_refresh_mce($ver)
	{
		// just a tinymce hack to refresh the cache
		$ver += 3;
		return $ver;
	}
	function wp_enqueue_scripts()
	{
		wp_enqueue_style('worldflag', $this->pluginDir . 'assets/flags.css');
	}
	function wp_head()
	{
		// nothing to put here at the moment
	}
	function wp_footer()
	{
		// nothing to put here at the moment
	}
	function shortcode($atts)
	{
		extract(shortcode_atts(array(
			'country' => 'np'
		), $atts));
		if (array_key_exists($country, $this->ar_countries)) {
			return "<img src=\"" . $this->pluginDir . "assets/blank.gif\" class=\"flag flag-{$country}\" alt=\"" . $this->ar_countries[strtolower($country)] . "\" title=\"" . $this->ar_countries[strtolower($country)] . "\">";
		}
	}
	function add_tinymce_buttons()
	{
		if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
			return;
		if (get_user_option('rich_editing') == 'true') {
			add_filter('mce_external_plugins', array(
				&$this,
				'add_tinymce_plugin'
			));
			add_filter('mce_buttons', array(
				&$this,
				'register_tinymce_buttons'
			));
		}
	}
	function add_tinymce_plugin($plugin_array)
	{
		$plugin_array['worldflag'] = $this->pluginDir . 'assets/tinymce/editor_plugin.js';
		return $plugin_array;
	}
	function register_tinymce_buttons($buttons)
	{
		array_push($buttons, "|", "worldflag");
		return $buttons;
	}
	function worldflag_dialog(){
		include 'assets/tinymce/dialog.php';
		die();

	}
}
$WorldFlag = new WorldFlag;