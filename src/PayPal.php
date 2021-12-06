<?php

namespace TechhDan\PayPal;

use Exception;

class PayPal
{
	protected $clientId;
	protected $clientSecret;
	protected $sandbox;
	protected $accessToken;

	public function __construct(string $clientId, string $clientSecret, bool $sandbox)
	{
		$this->clientId = $clientId;
		$this->clientSecret = $clientSecret;
		$this->sandbox = $sandbox;
		$this->setAccessToken();
	}

	public function setAccessToken()
	{
		$ch = curl_init('https://api-m.sandbox.paypal.com/v1/oauth2/token');
		$headers = [
			'Accept: application/json',
			'Accept-Language: en_US'
		];
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['grant_type' => 'client_credentials']));
		curl_setopt($ch, CURLOPT_USERPWD, "{$this->clientId}:{$this->clientSecret}");
		$response = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($response);
		if (!isset($response->access_token)) {
			throw new Exception($response->error_description ?? 'Unable to get access token');
		}
		$this->accessToken = $response->access_token;
	}

	public function getAccessToken()
	{
		return $this->accessToken;
	}
}