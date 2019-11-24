<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

//----------------------------------------------------------------------------
// Mailchimp API v3 REST Client
// ---------------------------------------------------------------------------
// Interface for communicating with the Mailchimp v3 API
//
// @author    Stefan Ashwell
// @version   1.0
// @updated   14/03/2016
//----------------------------------------------------------------------------
class Mailchimp {

  /**
	 * API Key
	 *
	 * @var	string[]
	 */
  private $_api_key;

  /**
	 * API Endpoint
	 *
	 * @var	string[]
	 */
  private $_api_endpoint = 'https://<dc>.api.mailchimp.com/3.0/';

  //----------------------------------------------------------------------------
  // Constructor - sets API config
  // ---------------------------------------------------------------------------
  // The constructor can be passed an array of config values
  //
  // @param	  array	$config = array()
  // @return	void
  //----------------------------------------------------------------------------
  public function __construct(array $config = array()) {

      $CI =& get_instance();

      $CI->load->config('mailchimp');

      if (count($config) > 0) {

  			$this->initialize($config);

  		} else {

  			$this->_api_key      = $CI->config->item('api_key');
        $this->_api_endpoint = $CI->config->item('api_endpoint');

  		}

      // Replace <dc> with correct datacenter
      list(, $datacentre) = explode('-', $this->_api_key);
      $this->_api_endpoint = str_replace('<dc>', $datacentre, $this->_api_endpoint);

  }

  //----------------------------------------------------------------------------
  // Initialize
  // ---------------------------------------------------------------------------
  // Initializes the required settings
  //
  // @param   array $config
  // @return  void
  //----------------------------------------------------------------------------
  public function initialize( $config = array() ) {

    if ( $config['api_key'] ) { $this->_api_key            = $config['api_key']; }
    if ( $config['api_endpoint'] ) { $this->_api_endpoint  = $config['api_endpoint']; }

  }

  //----------------------------------------------------------------------------
  // Call - Call an API method
  // ---------------------------------------------------------------------------
  // Every request needs the API key
  //
  // @param   string $httpVerb
  // @param   string $method
  // @param   array  $args
  // @return  array
  //----------------------------------------------------------------------------
  public function call( $httpVerb = 'POST', $method, $args = array() ) {

      return $this->_request( $httpVerb, $method, $args );

  }

  //----------------------------------------------------------------------------
  // Build Request URL
  // ---------------------------------------------------------------------------
  // Builds the request URL based on request type
  //
  // @param   string $httpVerb
  // @param   string $method
  // @param   array  $args
  // @return  string
  //----------------------------------------------------------------------------
  private function _build_request_url( $httpVerb = 'POST', $method, $args = array() ) {

    if ( $httpVerb == 'GET' ) {
      $params   = http_build_query($args);
      $url      = $this->_api_endpoint . $method . '?' . $params;
    } else {
      $url      = $this->_api_endpoint . $method;
    }

    return $url;

  }

  //----------------------------------------------------------------------------
  // Request - Makes a request
  // ---------------------------------------------------------------------------
  // Performs the HTTP request to the API
  //
  // @param   string $httpVerb
  // @param   string $method
  // @param   array  $args
  // @return  array
  //----------------------------------------------------------------------------
  private function _request($httpVerb, $method, $args = array()) {

      $url    = $this->_build_request_url($httpVerb, $method, $args);

      $ch     = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
      curl_setopt($ch, CURLOPT_USERPWD, "user:" . $this->_api_key);
      curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/3.0');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 10);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $httpVerb);
      $result = curl_exec($ch);
      curl_close($ch);

      return $result ? json_decode($result, true) : false;

  }

}
