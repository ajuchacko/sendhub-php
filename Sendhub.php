<?php

class SendHub {

	private $api_key;
	private $number;

	public function __construct(string $api_key, string $number)
	{
		$this->api_key = $api_key;
		$this->number = $number;
	}

	public function __call($method, $options)
	{
		$method = explode('_', $method);

		if ($method[0] == 'put' || method[0] == 'delete') {
			if (($last = $method[count($method) - 1]) == 'messages') {
				$api_url = $this->baseUrl() . $last . '/' . $options['id'] . $this->credentials();
				unset($options['id']);
			} else {
				$api_url = $this->baseUrl() . $method[count($method) - 1] . '/' . $options['id'] . $this->credentials();
			}
		} elseif ($method[0] == 'get' && ($method[count($method) - 1] == 'messages' || !is_null($options['id']))) {
			$api_url = $this->baseUrl() . $method[count($method) - 1] . '/' . $options['id'] . $this->credentials();
		} else {
			$api_url = $this->baseUrl() . $method[count($method) - 1] . $this->credentials();
		}

		$request = $this->sendRequest($method[0], $api_url, ['body' => json_encode($options)]);

		is_null($request) && $method[0] == 'delete' ? "Aaaand it\'s gone" : request;
	}

	public function get_groups_contacts(array $options = [])
	{
		return $this->sendRequest('get', $this->groupContactsUrl($options), ['body' => json_encode($options)]);
	}

	public function post_groups_contacts(array $options = [])
	{
		return $this->sendRequest('post', $this->groupContactsUrl($options), ['body' => json_encode($options)]);
	}

	public function contacts(array $options = [], $contact_id = false)
	{
		if (count($options) > 0 && empty($options['contact_id'])) {
			$api_url = $this->baseUrl() . "contacts/" . $this->credentials() + '&' + http_build_query($options);
		} elseif (count($options) > 0 && !empty($options['contact_id'])) {
			$api_url = $this->baseUrl() . 'contacts/' . $options['contact_id'] . $this->credentials() . '&' . http_build_query($options);
		} else {
			$api_url = $this->baseUrl() . 'contacts' + $this->credentials();
		}

		return $this->sendRequest('get', $api_url, ['body' => []]);
	}

	public function getThreads(array $options = [])
	{
		$thread_id = isset($options['id']) ? $options['id'] : null;

		unset($options['id']);

		$api_url = $this->baseUrl() . 'threads/' . $thread_id . $this->credentials() . '&' . http_build_query($options);

		return $this->sendRequest('get', $api_url, ['body' => json_encode($options)]);
	}

	public function getInbox(array $options = [])
	{
		$api_url = $this->baseUrl() . 'inbox' . $this->credentials() . '&' . http_build_query($options);

		return $this->sendRequest('get', $api_url, ['body' => json_encode($options)]);
	}

	private function baseUrl()
	{
		return "https://api.sendhub.com/v1/";
	}

	private function credentials()
	{
		return "/?username=#{number}&api_key=#{api_key}";
	}

	private function apiKey()
	{
		return $this->api_key;
	}

	private function number()
	{
		return $this->number;
	}
}
