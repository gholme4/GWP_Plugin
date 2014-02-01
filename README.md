GWP_Plugin
==========

GWP_Plugin is a class that implements common functions of a WordPress plugin such as wp_enqueue_script() and add_image_size(). Its purpose is to reduce the need of writing global functions and provide a few extra useful functions.

*GWP_Plugin requires PHP 5.3.0 and above*

**[View Documentation](http://gholme4.github.io/GWP_Plugin/classes/GWP_Plugin.html "documentation")**

Usage
----------
```php
    require_once(dirname(__FILE__) . "/GWP_Plugin/GWP_Plugin.php");
    
    /* Create new instance of GWP_Plugin */
    $my_plugin = new GWP_Plugin();
    /* Require GWP_Plugin class */
    
    /* Create instance of GWP_Plugin */
    $my_plugin = new GWP_Plugin(__FILE__);
    
    /* Enable debug mode */
    $my_plugin->debug = true;
    
    /* Code ran when plugin is activated */
    $my_plugin->activate = function () {
    	error_log("My Plugin activated", 0);	
    };
    
    /* Code ran when plugin is deactivated */
    $my_plugin->deactivate = function () {
    	error_log("My Plugin deactivated", 0);	
    };
    
    /* Register front end styles */
    $my_plugin->add_front_end_styles(
    	array(
    		array(
    			"handle" => "my-style",
    			"src" => plugins_url('/css/my-styles.css?rand=' . rand(), __FILE__),
    			"deps" => array(),
    			"ver" => false,
    			"media" => "all"
    		),
    		array(
    			"handle" => "one-more-style",
    			"src" => plugins_url('/css/one-more-style.css?rand=' . rand(), __FILE__),
    			"deps" => array(),
    			"ver" => false,
    			"media" => "all"
    		)
    	)
    	,
    	/* Set action priority of front end styles */
    	15
    );
    
    /* Register admin styles */
    $my_plugin->add_admin_styles(
    	array(
    		array(
    			"handle" => "my-admin-style",
    			"src" => plugins_url('/css/my-admin-style.css?rand=' . rand(), __FILE__),
    			"deps" => array(),
    			"ver" => false,
    			"media" => "all"
    		)
    	),
    	/* Set action priority of admin styles */
    	15
    );
    
    /* Register front end  scripts */
    $my_plugin->add_front_end_scripts(
    	array(
    		array(
    			"handle" => "my-script",
    			"src" => plugins_url('/js/my-script.js', __FILE__),
    			"deps" => array('jquery'),
    			"ver" => false,
    			"in_footer" => true
    		),
    		array(
    			"handle" => "another-script",
    			"src" => plugins_url('/js/another-script.js', __FILE__),
    			"deps" => array('jquery'),
    			"ver" => false,
    			"in_footer" => true
    		)
    	),
    	/* Set action priority of front end scripts */
    	15
    );
    
    /* Register admin scripts */
    $my_plugin->add_admin_scripts(
    	array(
    		array(
    			"handle" => "admin-script",
    			"src" => plugins_url('/js/admin-script.js', __FILE__),
    			"deps" => array('jquery'),
    			"ver" => false,
    			"in_footer" => true
    		)
	 ),
    	/* Set action priority of admin scripts */
    	15
    	
    );
    
    /* Add custom image sizes */
    $my_plugin->image_sizes(
    	array (
    		array("name" => "wide-small", "width" => 320, "height" => 240, "crop" => true),
    		array("name" => "tall-small", "width" => 320, "height" => 480, "crop" => true)
    	)
    );
    
    
    $my_plugin->wp_head = function () {
    	// do stuff within theme header
    };
    
    $my_plugin->admin_head = function () {
    	// do stuff within admin header
    };
    
    /* Initialize plugin */
    $my_plugin->init(function () {
    	error_log("My Plugin initialized", 0);	
    });
```