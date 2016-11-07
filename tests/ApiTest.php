<?php

namespace ACMS\Tests;

use ACMS\Api;

//fwrite(STDERR, print_r($example_credential, TRUE));

class ApiTest extends \PHPUnit_Framework_TestCase {

	protected function setUp(){
        $this->api = new Api("accredible_secret123", true);
    }

    protected function tearDown(){
    	
    }

    public function testSetAPIKey(){
        // Check the API key is set
        $this->assertEquals("accredible_secret123", $this->api->getAPIKey());
    }

    public function testGetCredential(){
    	// Check if we can get a Credential
        $example_credential = $this->api->get_credential(10000005);
		$this->assertEquals(10000005, $example_credential->credential->id);
    }

    public function testGetCredentials(){
    	$new_credential = $this->api->create_credential("John Doe", "john@example.com", 54018);

    	// Check if we can get credentials given an email
		$example_credentials = $this->api->get_credentials(null, "john@example.com", 1);
		$example_credential = array_values($example_credentials->credentials)[0];
		
		$this->assertEquals("john@example.com", $example_credential->recipient->email);

		//cleanup
		$this->api->delete_credential($new_credential->credential->id);
    }

    public function testCreateCredential(){
    	//Check we can create a Credential
		$new_credential = $this->api->create_credential("John Doe", "john@example.com", 54018);
		$this->assertEquals("John Doe", $new_credential->credential->recipient->name);

		//cleanup
		$this->api->delete_credential($new_credential->credential->id);
    }

    public function testUpdateCredential(){
    	$new_credential = $this->api->create_credential("John Doe", "john@example.com", 54018);

    	//Check we can update a Credential
		$updated_credential = $this->api->update_credential($new_credential->credential->id, "Jonathan Doe");
		$this->assertEquals("Jonathan Doe", $updated_credential->credential->recipient->name);

		//cleanup
		$this->api->delete_credential($updated_credential->credential->id);
    }

    public function testDeleteCredential(){
    	$new_credential = $this->api->create_credential("John Doe", "john@example.com", 54018);

    	// Can we delete a Credential
		$response = $this->api->delete_credential($new_credential->credential->id);
		$this->assertEquals("John Doe", $response->credential->recipient->name);
    }

    public function testGetGroup(){
    	$group = $this->api->create_group("PHPTest", "Test course", "Test course description.");

    	// Can we get a group?
		$requested_group = $this->api->get_group($group->group->id);
		$this->assertEquals("PHPTest", $requested_group->group->name);

		//cleanup
		$response = $this->api->delete_group($requested_group->group->id);
    }

    public function testCreateGroup(){
    	// Can we create a Group
		$group = $this->api->create_group("PHPTest", "Test course", "Test course description.");
		$this->assertEquals("PHPTest", $group->group->name);

		//cleanup
		$response = $this->api->delete_group($group->group->id);
    }

    public function testUpdateGroup(){
    	$group = $this->api->create_group("PHPTest", "Test course", "Test course description.");

    	// Can we update a group?
		$requested_group = $this->api->update_group($group->group->id, 'PHPTest2');
		$this->assertEquals("PHPTest2", $requested_group->group->name);

		//cleanup
		$response = $this->api->delete_group($requested_group->group->id);
    }

    public function testDeleteGroup(){
    	$group = $this->api->create_group("PHPTest", "Test course", "Test course description.");

    	// Can we delete a group?
		$response = $this->api->delete_group($group->group->id);
		$this->assertEquals("PHPTest", $response->group->name);
    }

}