<?php
require_once(dirname(__FILE__) . "/lib/mobile-detect/Mobile_Detect.php");
/**
* GWP_Plugin
* Class that implements common functions of a WordPress plugin in an effort to reduce the amount of functions written in the global namespace.
* Requires PHP 5.3.0 and above
*
* @version 0.1
* @package GWP_Plugin
* @link      http://gholme4.github.io/GWP_Plugin/classes/GWP_Plugin.html
* @copyright Copyright (c) 2014 George Holmes II
* @license   GPLv2 or later
*/

class GWP_Plugin {
	
	/**
	* Logs class generated warnings to error log if true
	* 
	* @since GWP_Plugin (0.1)
	* @var boolean $debug
	*/
	public $debug = false;
	
	/**
	* Path to plugin file
	* 
	* @since GWP_Plugin (0.1)
	* @access protected
	* @var string $plugin_path
	*/
	protected $plugin_path;
	
	/**
	* Array of front end stylesheets
	* 
	* @since GWP_Plugin (0.1)
	* @access protected
	* @ignore
	* @var array $front_end_styles
	*/
	protected $front_end_styles = array();
	
	/**
	* Front end stylesheets action priority
	* 
	* @since GWP_Plugin (0.1)
	* @var int $front_end_styles_priority
	*/
	public $front_end_styles_priority = 10;
	
	/**
	* Array of admin stylesheets
	* 
	* @since GWP_Plugin (0.1)
	* @access protected
	* @ignore
	* @var array $admin_styles
	*/
	protected $admin_styles = array();
	
	/**
	* Admin stylesheets action priority
	* 
	* @since GWP_Plugin (0.1)
	* @var int $admin_styles_priority
	*/
	public $admin_styles_priority = 10;
	
	/**
	* Array of front end scripts
	* 
	* @since GWP_Plugin (0.1)
	* @access protected
	* @ignore
	* @var array $front_end_scripts
	*/
	protected $front_end_scripts = array();
	
	/**
	* Front end scripts action priority
	* 
	* @since GWP_Plugin (0.1)
	* @var int $front_end_scripts_priority
	*/
	public $front_end_scripts_priority = 10;
	
	/**
	* Array of admin scripts
	* 
	* @since GWP_Plugin (0.1)
	* @access protected
	* @ignore
	* @var array $admin_scripts
	*/
	protected $admin_scripts = array();
	
	/**
	* Admin scripts action priority
	* 
	* @since GWP_Plugin (0.1)
	* @var int $admin_scripts_priority
	*/
	public $admin_scripts_priority = 10;
	
	/**
	* Array of image sizes
	* 
	* @since GWP_Plugin (0.1)
	* @access protected
	* @ignore
	* @var array $image_sizes
	*/
	protected $image_sizes = array();
	
	/**
	* Array of admin menu pages
	* 
	* @since GWP_Plugin (0.1)
	* @access protected
	* @ignore
	* @var array $single_menu_pages
	*/
	protected $single_menu_pages = array();
	
	/**
	* Array of admin menu page groups
	* 
	* @since GWP_Plugin (0.1)
	* @access protected
	* @ignore
	* @var array $group_menu_pages
	*/
	protected $group_menu_pages = array();
	
	/**
	* User defined function containing code to be ran when the plugin is activated.
	* 
	* <code style="width: 99%;">
	* &lt;?php
	* 
	* $my_plugin = new GWP_Plugin();
	* $my_plugin->activate = function () {
	*	&nbsp;&nbsp;&nbsp; // do stuff when plugin is activated	
	* };
	* $my_plugin->init();
	*
	* ?&gt;
	* </code>
	* @since GWP_Plugin (0.1)
	* @var object  $activate
	*/
	public $activate;
	
	/**
	* User defined function containing code to be ran when the plugin is deactivated.
	* 
	* <code style="width: 99%;">
	* &lt;?php
	* 
	* $my_plugin = new GWP_Plugin();
	* $my_plugin->deactivate = function () {
	*	&nbsp;&nbsp;&nbsp; // do stuff when plugin is deactivated	
	* };
	* $my_plugin->init();
	*
	* ?&gt;
	* </code>
	* @since GWP_Plugin (0.1)
	* @var object $deactivate
	*/
	public $deactivate;
	
	/**
	* User defined function containing code to be triggered within the <head></head> section of the active template
	* 
	* <code style="width: 99%;">
	* &lt;?php
	* 
	* $my_plugin = new GWP_Plugin();
	* $my_plugin->wp_head = function () {
	*	&nbsp;&nbsp;&nbsp; // do stuff within theme header	
	* };
	* $my_plugin->init();
	*
	* ?&gt;
	* </code>
	* @since GWP_Plugin (0.1)
	* @var object  $wp_head
	*/
	public $wp_head;
	
	/**
	* User defined function containing code to be triggered within the <head></head> section of the WordPress dashboard
	* 
	* <code style="width: 99%;">
	* &lt;?php
	* 
	* $my_plugin = new GWP_Plugin();
	* $my_plugin->admin_head = function () {
	*	&nbsp;&nbsp;&nbsp; // do stuff within admin header	
	* };
	* $my_plugin->init();
	*
	* ?&gt;
	* </code>
	* @since GWP_Plugin (0.1)
	* @var object  $admin_head
	*/
	public $admin_head;
	
	/**
	* Constructor
	* @param string $path File path of plugin
	* @since GWP_Plugin (0.1)
	*/
	public function __construct ($path) {
		$this->plugin_path = $path;
		/* If this file is called directly, abort. */
		if ( ! defined( 'WPINC' ) ) {
			die;
		} 
		
		/* If PHP version if less than 5.3.0 abort */
		if ( phpversion() < 5.3 ) {
			die("GWP_Plugin requires PHP 5.3.0 and above. Please upgrade PHP.");
		} 
		
		/* Require pluggable functions */
		if (is_admin()) require_once(ABSPATH . 'wp-includes/pluggable.php');
	}
	
	/**
	* Determines if user's device is handheld or desktop.
	* Returns true if user is on a mobile device and false if user is on a desktop device.
	*
	* <h4> Usage </h4>
	* <code style="width: 99%;">
	* &lt;?php
	* if (GWP_Plugin::is_mobile() == true)
	* {
	*	&nbsp;&nbsp;&nbsp;// do stuff exclusive to mobile devices
	* }
	* ?&gt;
	* </code>
	* @since GWP_Plugin (0.1)
	* @static
	* @return boolean 
	*/
	public static function is_mobile () {
		/* Tell plugin if user is on a mobile device */
		$detect = new Mobile_Detect();
		return $detect->isMobile();
		
	}
	
	/**
	* Validates array of styles to get registered
	*
	* @since GWP_Plugin (0.1)
	* @param array $styles
	* @param string $location
	*/
	protected function add_styles ($styles, $location) {
		/* If $styles isn't an array, return */
		if (gettype($styles) != "array")
		{
			return;	
		}
		
		/* Determine whether or not $styles is a multilevel array */
		$array_depth = $this->array_depth($styles);
		
		/* If $styles is empty or the array is invalid, return */
		if (count($styles) < 1 || $array_depth != 3)
		{
			return;	
		}
		
		
		foreach ($styles as $style)
		{
			
			$new_style = $style;	
			
			if (!$new_style['deps'])
				$new_style['deps'] = array();	
			if (!$new_style['ver'])
				$new_style['ver'] = false;
			if (!$new_style['media'])
				$new_style['media'] = "all";
			
			if ($new_style['src'] && $new_style['handle'])
			{
				if ($location == "front_end")
					array_push($this->front_end_styles, $new_style);	
				else
					array_push($this->admin_styles, $new_style);	
			
			}
			else
			{
				$this->log("Error: 'src' and 'handle' are required when adding styles.");	
				return;	
			}
		}
		
		
		
	}
	
	/**
	* Add front end styles to be registered
	*
	* <h4> Usage </h4>
	* <code style="width: 99%;">
	* &lt;?php
	* $my_plugin = new GWP_Plugin();
	*
	* $my_plugin->add_front_end_styles(array (
	* 	array (
	*		array(
	*			"handle" => "another-style",
	*			"src" => plugins_url('/css/another-style.css?rand=' . rand(), __FILE__)
	*		),
	*		array(
	*			"handle" => "yet-another-style",
	*			"src" => plugins_url('/css/yet-another-style.css?rand=' . rand(), __FILE__)
	*		)
	*	),
	*	15 
	*	
	* );
	*
	* $my_plugin->init();
	* ?&gt;
	* </code>
	* @since GWP_Plugin (0.1)
	* @param array $styles
	* @param int $priority
	*/
	public function add_front_end_styles ($styles, $priority = 10) {
		$this->add_styles($styles, "front_end");
		$this->front_end_styles_priority = $priority;
	}
	
	/**
	* Enqueue front end styles. Should never be called directly.
	*
	* @access protected
	* @ignore
	* @since GWP_Plugin (0.1)
	*/
	public function enqueue_front_end_styles () {
		
		foreach ($this->front_end_styles as $style)
		{
			wp_enqueue_style( $style['handle'], $style['src'], $style['deps'], $style['ver'], $styles['media']);
		}
	}
	
	/**
	* Add admin styles to be registered
	*
	* <h4> Usage </h4>
	* <code style="width: 99%;">
	* &lt;?php
	* $my_plugin = new GWP_Plugin();
	*
	* $my_plugin->add_admin_styles(array (
	* 	array (
	*		array(
	*			"handle" => "another-style",
	*			"src" => plugins_url('/css/another-style.css?rand=' . rand(), __FILE__)
	*		),
	*		array(
	*			"handle" => "yet-another-style",
	*			"src" => plugins_url('/css/yet-another-style.css?rand=' . rand(), __FILE__)
	*		)
	*	),
	*	15 
	*	
	* );
	*
	* $my_plugin->init();
	* ?&gt;
	* </code>
	* @since GWP_Plugin (0.1)
	* @param array $styles
	* @param int $priority
	*/
	public function add_admin_styles ($styles, $priority = 10) {
		$this->add_styles($styles, "admin");
		$this->admin_styles_priority = $priority;
	}
	
	/**
	* Enqueue admin styles. Should never be called directly.
	*
	* @access protected
	* @ignore
	* @since GWP_Plugin (0.1)
	*/
	public function enqueue_admin_styles () {
		
		foreach ($this->admin_styles as $style)
		{
			wp_enqueue_style( $style['handle'], $style['src'], $style['deps'], $style['ver'], $styles['media']);
		}
	}
	
	/**
	* Validates array of scripts to get registered
	*
	* @since GWP_Plugin (0.1)
	* @param array $scripts
	* @param string $location
	*/
	protected function add_scripts ($scripts, $location) {
		
		/* If $scripts isn't an array, return */
		if (gettype($scripts) != "array")
		{
			return;	
		}
		
		/* Determine whether or not $scripts is a multilevel array */
		$array_depth = $this->array_depth($scripts);
		
		/* If $scripts is empty or the array is invalid, return */
		if (count($scripts) < 1 || $array_depth != 3)
		{
			return;	
		}
	
		foreach ($scripts as $script)
		{
			
			$new_script = $script;	
			
			if (!$new_script['deps'])
				$new_script['deps'] = array();	
			if (!$new_script['ver'])
				$new_script['ver'] = false;
			if (!$new_script['in_footer'])
				$new_script['in_footer'] = false;
			
			if ($new_script['src'] && $new_script['handle'])
			{
				if ($location == "front_end")
					array_push($this->front_end_scripts, $new_script);	
				else
					array_push($this->admin_scripts, $new_script);	
			
			}
			else
			{
				$this->log("Error: 'src' and 'handle' are required when adding scripts.");	
				return;	
			}
		}
		
	}
	
	/**
	* Add front end scripts to be registered
	*
	* <h4> Usage </h4>
	* <code style="width: 99%;">
	* &lt;?php
	* $my_plugin = new GWP_Plugin();
	*
	* $my_plugin->add_front_end_scripts(array (
	* 	array (
	*		array(
	*			"handle" => "another-script",
	*			"src" => plugins_url('/js/another-script.js', __FILE__)
	*		),
	*		array(
	*			"handle" => "yet-another-style",
	*			"src" => plugins_url('/js/yet-another-script.js', __FILE__)
	*		)
	*	),
	*	15 
	*	
	* );
	*
	* $my_plugin->init();
	* ?&gt;
	* </code>
	* @since GWP_Plugin (0.1)
	* @param array $scripts
	* @param int $priority
	*/
	public function add_front_end_scripts ($scripts, $priority = 10) {
		$this->add_scripts($scripts, "front_end");
		$this->front_end_scripts_priority = $priority;
	}
	
	/**
	* Enqueue front end scripts. Should never be called directly.
	*
	* @access protected
	* @ignore
	* @since GWP_Plugin (0.1)
	*/
	public function enqueue_front_end_scripts () {
		
		foreach ($this->front_end_scripts as $script)
		{
			wp_enqueue_script( $script['handle'], $script['src'], $script['deps'], $script['ver'], $script['in_footer']);
		}
	}
	
	/**
	* Add admin scripts to be registered
	*
	* <h4> Usage </h4>
	* <code style="width: 99%;">
	* &lt;?php
	* $my_plugin = new GWP_Plugin();
	*
	* $my_plugin->add_admin_scripts(array (
	* 	array (
	*		array(
	*			"handle" => "another-script",
	*			"src" => plugins_url('/css/another-script.js', __FILE__)
	*		),
	*		array(
	*			"handle" => "yet-another-script",
	*			"src" => plugins_url('/css/yet-another-script.js', __FILE__)
	*		)
	*	),
	*	15 
	*	
	* );
	*
	* $my_plugin->init();
	* ?&gt;
	* </code>
	* @since GWP_Plugin (0.1)
	* @param array $scripts
	* @param int $priority
	*/
	public function add_admin_scripts ($scripts, $priority = 10) {
		$this->add_scripts($scripts, "admin");
		$this->admin_scripts_priority = $priority;
	}
	
	/**
	* Enqueue admin scripts. Should never be called directly.
	*
	* @access protected
	* @ignore
	* @since GWP_Plugin (0.1)
	*/
	public function enqueue_admin_scripts () {
		
		foreach ($this->admin_scripts as $script)
		{
			wp_enqueue_script( $script['handle'], $script['src'], $script['deps'], $script['ver'], $script['in_footer']);
		}
	}
	
	/**
	* Add custom image sizes
	*
	* <h4> Usage </h4>
	* <code style="width: 99%;">
	* &lt;?php
	* $my_plugin = new GWP_Plugin();
	* $my_plugin->image_sizes(
	*	array (
	*		array("name" => "wide-small", "width" => 320, "height" => 240, "crop" => true),
	*		array("name" => "wide-medium", "width" => 640, "height" => 480, "crop" => true),
	*	)
	* );
	*
	* $my_plugin->init();
	* ?&gt;
	* </code>
	*
	* @param array $sizes
	* @since GWP_Plugin (0.1)
	*/
	public function image_sizes ($sizes) {
		
		foreach ($sizes as $size)
		{
			if ($size['name'] && $size['width'] && $size['height'])
			{
				$new_size = $size;
				if (!$new_size['crop'])
					$new_size['crop'] = false;
				array_push($this->image_sizes, $new_size);
				
			}
			else
			{
				$this->log("Error: 'name', 'width', and 'height' are required for image sizes.");
			}
		}
	}
	
	/**
	* Add post-thumbnail support and custom image sizes
	*
	* @param array $sizes
	* @ignore
	* @since GWP_Plugin (0.1)
	*/
	public function add_image_sizes ($sizes) {
		add_theme_support('post-thumbnails');
		foreach ($this->image_sizes as $size)
		{
			
			add_image_size( $size['name'], $size['width'], $size['height'], $size['crop']);
			
		}
	}
	
	/**
	* Create a custom menu page in the WordPress admin
	*
	* <h4> Usage </h4>
	* <code style="width: 99%;">
	* &lt;?php
	* $my_plugin = new GWP_Plugin();
	*
	* $my_plugin->single_menu_page(
	*	array (
	*	 	"page_title" => "My Plugin Page",
	*		"menu_title" => "My Plugin Page",
	*		"menu_slug" => "my_plugin_page",
	*		"icon" => plugins_url('/images/menu-icon.png', __FILE__),
	*		"position" => 100,
	*		"page_content" => function () {
	*			echo "&lt;h1&gt;My Plugin Page&lt;/h1&gt;";
	*		}
	*	)	
	* );
	*
	* $my_plugin->init();
	* ?&gt;
	* </code>
	* @since GWP_Plugin (0.1)
	* @param array $single_page
	*/
	public function single_menu_page ($single_page) {
		if (!$single_page['page_title'] || !$single_page['menu_title'] || !$single_page['page_content'] || !$single_page['menu_slug'])
		{
			$this->log('Error: "page_title", "menu_title", "menu_slug", and "page_content" are required when adding a menu page.');	
			return;
		}
		
		if (!$single_page['icon'])
			$single_page['icon'] = "";
		if (!$single_page['position'])
			$single_page['position'] = 100;
		$single_page['menu_slug'] = "GWP_Plugin_" .$single_page['menu_slug'];
		array_push($this->single_menu_pages, $single_page);
	}
	
	/**
	* Add single menu pages
	*
	* @ignore
	* @since GWP_Plugin (0.1)
	*/
	public function add_single_menu_pages () {
		
		foreach ($this->single_menu_pages as $single_page)
		{
			add_menu_page( $single_page['page_title'], $single_page['menu_title'], 'manage_options', $single_page['menu_slug'], $single_page['page_content'], $single_page['icon'], $single_page['position']);
			
		}
	}
	
	/**
	* Create a custom group of menu pages in the WordPress admin
	*
	* <h4> Usage </h4>
	* <code style="width: 99%;">
	* &lt;?php
	* $my_plugin = new GWP_Plugin();
	*
	* $my_plugin->group_menu_pages(
	*	array (
	*		"menu_title" => "My Plugin Page",
	*	)	
	* );
	*
	* $my_plugin->init();
	* ?&gt;
	* </code>
	* @since GWP_Plugin (0.1)
	* @param array $single_page
	*/
	public function group_menu_pages ($group_pages) {
		
	}
	
	/**
	* Add single menu pages
	*
	* @ignore
	* @since GWP_Plugin (0.1)
	*/
	public function add_group_menu_pages () {
		
		foreach ($this->group_menu_pages as $group_pages)
		{
			
		}
	}
			
		
	/**
	* Writes messages to log
	* 
	* @ignore
	* @since GWP_Plugin (0.1)
	*/
	protected function log ($message) {
		if ($this->debug == true)
			error_log($message, 0);	
	}
	
	/**
	* @ignore 
	*/
	protected function array_depth($array) {
	    $max_depth = 1;
	
	    foreach ($array as $value) {
		  if (is_array($value)) {
			$depth = $this->array_depth($value) + 1;
	
			if ($depth > $max_depth) {
			    $max_depth = $depth;
			}
		  }
	    }
	
	    return $max_depth;
	}
	
	/**
	* Initializes plugin. Can be passed an optional callback.
	* 
	* <code style="width: 99%;">
	* &lt;?php
	* 
	* $my_plugin = new GWP_Plugin();
	* $my_plugin->init(function () {
	*	// callback code
	*});
	*
	* ?&gt;
	* </code>
	* @param object $callback
	* @since GWP_Plugin (0.1)
	*/
	public function init ($callback = NULL) {
		
		/* Run plugin activation code */
		if (gettype($this->activate) == "object")
		{
			$activate = $this->activate;
			register_activation_hook($this->plugin_path, $activate);
		}
		
		/* Run plugin deactivation code */
		if (gettype($this->deactivate) == "object")
		{
			$deactivate = $this->deactivate;
			register_deactivation_hook($this->plugin_path, $deactivate);
		}
		
		/* Add wp_head code */
		if (gettype($this->wp_head) == "object")
		{
			$wp_head = $this->wp_head;
			add_action('wp_head', $wp_head);
		}
		
		/* Add admin_head code */
		if (gettype($this->admin_head) == "object")
		{
			$admin_head = $this->admin_head;
			add_action('admin_head', $admin_head);
		}
		
		/* Enqueue front end styles */
		add_action('wp_enqueue_scripts',  array( $this, 'enqueue_front_end_styles' ), $this->front_end_styles_priority);
		
		/* Enqueue admin styles */
		add_action('admin_enqueue_scripts',  array( $this, 'enqueue_admin_styles' ), $this->admin_styles_priority);
		
		/* Enqueue front end scripts */
		add_action('wp_enqueue_scripts',  array( $this, 'enqueue_front_end_scripts' ), $this->front_end_scripts_priority);
		
		/* Enqueue admin scripts */
		add_action('admin_enqueue_scripts',  array( $this, 'enqueue_admin_scripts' ), $this->admin_scripts_priority);
		
		/* Add custom image sizes */
		add_action('plugins_loaded', array( $this, 'add_image_sizes' ));
		
		/* Add single menu pages */
		add_action('admin_menu', array( $this, 'add_single_menu_pages' ));
		if ($callback)
			$callback();
			
	}
	
	
}
?>