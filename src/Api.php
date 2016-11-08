<?php

namespace ACMS;

// For composer dependencies
require 'vendor/autoload.php';

/**
 * API Wrappers
 *
 */
class Api {

	private $api_key;

	private $api_endpoint = "https://api.accredible.com/v1/";

	public function setAPIKey($key) { 
        $this->api_key = $key; 
    }
    public function getAPIKey() { 
        return $this->api_key; 
    }

    public function __construct($api_key, $test = null){
        $this->setAPIKey($api_key);

        if (null !== $test) {
    	    $test = "https://staging.accredible.com/v1/";
    	}
    }

    /*
     * Strip out keys with a null value from an object
     * http://stackoverflow.com/a/15953991
     */
    public function strip_empty_keys($object){

		$json = json_encode($object);
		$json = preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?/', '', $json);
		$object = json_decode($json);

		return $object;
    }
    
    /*
	 * Get a Credential
	 */
	public function get_credential($id){
		$client = new \GuzzleHttp\Client();
		
		$response = $client->get($this->api_endpoint . 'credentials/' . $id, ['headers' =>  ['Authorization' => 'Token token="'.$this->getAPIKey().'"']]);
		
		$result = json_decode($response->getBody());
		return $result;
	}

	/*
	 * Get Credentials - can include search params and URL encodes text params like email
	 */
	public function get_credentials($group_id = null, $email = null, $page_size = null, $page = 1){
		$client = new \GuzzleHttp\Client();
		
		$response = $client->get($this->api_endpoint. 'credentials?group_id=' . $group_id . '&email=' . rawurlencode($email) . '&page_size=' . $page_size . '&page=' . $page, ['headers' =>  ['Authorization' => 'Token token="'.$this->getAPIKey().'"']]);
		
		$result = json_decode($response->getBody());
		return $result;
	}

	/*
	 *	Creates a Credential given an existing Group
	 */
	public function create_credential($recipient_name, $recipient_email, $course_id, $issued_on = null, $expired_on = null, $custom_attributes = null){

		$data = array(  
		    "credential" => array( 
		    	"cohort_id" => $course_id,
		        "recipient" => array( 
		            "name" => $recipient_name,
		            "email" => $recipient_email
		        ),
		        "issued_on" => $issued_on,
		        "expired_on" => $expired_on,
		        "custom_attributes" => $custom_attributes
		    ) 
		);

		$client = new \GuzzleHttp\Client();

		$response = $client->post($this->api_endpoint.'credentials', [
		    'headers' =>  ['Authorization' => 'Token token="'.$this->getAPIKey().'"'],
		    'json' => $data
		]);

		$result = json_decode($response->getBody());

		return $result;
	}

	/*
	 *	Updates a Credential
	 */
	public function update_credential($id, $recipient_name = null, $recipient_email = null, $course_id = null, $issued_on = null, $expired_on = null, $custom_attributes = null){

		$data = array(  
		    "credential" => array( 
		    	"cohort_id" => $course_id,
		        "recipient" => array( 
		            "name" => $recipient_name,
		            "email" => $recipient_email
		        ),
		        "issued_on" => $issued_on,
		        "expired_on" => $expired_on,
		        "custom_attributes" => $custom_attributes
		    ) 
		);
		$data = $this->strip_empty_keys($data);

		$client = new \GuzzleHttp\Client();

		$response = $client->post($this->api_endpoint.'credentials/'.$id, [
		    'headers' =>  ['Authorization' => 'Token token="'.$this->getAPIKey().'"'],
		    'json' => $data
		]);

		$result = json_decode($response->getBody());

		return $result;
	}

	/*
	 * Delete a Credential
	 */
	public function delete_credential($id){
		$client = new \GuzzleHttp\Client();
		
		$response = $client->delete($this->api_endpoint.'credentials/' . $id, ['headers' =>  ['Authorization' => 'Token token="'.$this->getAPIKey().'"']]);
		
		$result = json_decode($response->getBody());

		return $result;
	}

	/*
	 *	Create a new Group
	 */
	public function create_group($name, $course_name, $course_description, $course_link = null){
		$data = array(  
		    "group" => array( 
		    	"name" => $name,
		    	"course_name" => $course_name,
				"course_description" => $course_description,
    			"course_link" => $course_link
		    ) 
		);

		$client = new \GuzzleHttp\Client();

		$response = $client->post($this->api_endpoint.'issuer/groups', [
		    'headers' =>  ['Authorization' => 'Token token="'.$this->getAPIKey().'"'],
		    'json' => $data
		]);

		$result = json_decode($response->getBody());

		return $result;
	}

	/*
	 * Get a Group
	 */
	public function get_group($id){
		$client = new \GuzzleHttp\Client();
		
		$response = $client->get($this->api_endpoint.'issuer/groups/' . $id, ['headers' =>  ['Authorization' => 'Token token="'.$this->getAPIKey().'"']]);
		
		$result = json_decode($response->getBody());
		return $result;
	}

	/*
	 *	Update a Group
	 */
	public function update_group($id, $name = null, $course_name = null, $course_description = null, $course_link = null){

		$data = array(  
		    "group" => array( 
		    	"name" => $name,
		    	"course_name" => $course_name,
				"course_description" => $course_description,
    			"course_link" => $course_link
		    ) 
		);
		$data = $this->strip_empty_keys($data);

		$client = new \GuzzleHttp\Client();

		$response = $client->put($this->api_endpoint.'issuer/groups/'.$id, [
		    'headers' =>  ['Authorization' => 'Token token="'.$this->getAPIKey().'"'],
		    'json' => $data
		]);

		$result = json_decode($response->getBody());

		return $result;
	}

	/*
	 * Delete a Credential
	 */
	public function delete_group($id){
		$client = new \GuzzleHttp\Client();
		
		$response = $client->delete($this->api_endpoint.'issuer/groups/' . $id, ['headers' =>  ['Authorization' => 'Token token="'.$this->getAPIKey().'"']]);
		
		$result = json_decode($response->getBody());

		return $result;
	}
}

