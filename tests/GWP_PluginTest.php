<?php

class GWP_PluginText extends \PHPUnit_Framework_TestCase
{
	
	
	public function test_is_mobile()
	{
		$new_plugin = new GWP_Plugin();
		
		/* GWP_Plugin::is_mobile() should return a boolean */
		$this->assertInternalType("boolean", GWP_Plugin::is_mobile());
		
	}

}

?>