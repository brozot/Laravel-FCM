<?php namespace LaravelFCM\Downstream;

use LaravelFCM\FCMRequest;
use LaravelFCM\Message\Options;
use LaravelFCM\Message\PayloadData;
use LaravelFCM\Message\PayloadNotification;
use \GuzzleHttp\Psr7\Response as GuzzleResponse;

class FCMDownstream extends FCMRequest {

	const MAX_TOKEN_PER_REQUEST = 1000;

	/**
	 * send a Downstream message to a unique device with is registration Token
	 * or to multiples device with an array of registration token
	 *
	 * @param String|array             $to
	 * @param Options|null             $options
	 * @param PayloadNotification|null $notification
	 * @param PayloadData|null         $data
	 *
	 * @return Response|null
	 */
	public function sendTo($to, Options $options = null, PayloadNotification $notification = null, PayloadData $data = null)
	{
		$url = $this->config[ 'server_send_url' ];
		$response = null;

		if (is_array($to)) {
			$partialTokens = array_chunk($to, self::MAX_TOKEN_PER_REQUEST, false);
			foreach ($partialTokens as $tokens) {
				$responsePartial = $this->post($url, $tokens, $options, $notification, $data);
				if (!$response) {
					$response = $responsePartial;
				}
				else {
					$response->merge($responsePartial);
				}
			}
		}
		else {
			$response = $this->post($url, $to, $options, $notification, $data);
		}

		return $response;
	}

	/**
	 * Send a message to a group of devices identified with their notification key
	 * To create or manage a Group @see \LaravelFCM\Group\FCMGroup
	 *
	 * @param                          $notificationKey
	 * @param Options|null             $options
	 * @param PayloadNotification|null $notification
	 * @param PayloadData|null         $data
	 *
	 * @return Response
	 */
	public function sendToGroup($notificationKey, Options $options = null, PayloadNotification $notification = null, PayloadData $data = null)
	{
		$url = $this->config[ 'server_send_url' ];
		$data = $this->buildRequest($notificationKey, $options, $notification, $data);

		$response = $this->client->post($url, $data);

		return $this->constructResponse($response, $notificationKey);
	}

	protected function buildRequest($to, Options $options = null, PayloadNotification $notification = null, PayloadData $data = null)
	{
		return [
			'headers' => $this->buildRequestHeader(),
			'json'    => $this->buildRequestData($to, $options, $notification, $data)
		];
	}

	protected function buildRequestData($toOrRegistrationIds, Options $options = null, PayloadNotification $notification = null, PayloadData $data = null)
	{
		$notification = $notification ? $notification->toArray() : null;
		$data = $data ? $data->toArray() : null;

		$to = null;
		$registrationIds = null;
		if (is_array($toOrRegistrationIds)) {
			$registrationIds = $toOrRegistrationIds;
		}
		else {
			$to = $toOrRegistrationIds;
		}

		$message = [
			'to'               => $to,
			'registration_ids' => $registrationIds,
			'condition'        => $this->conditions,
			'notification'     => $notification,
			'data'             => $data
		];

		if ($options) {
			$message = array_merge($message, $options->toArray());
		}

		$message = array_filter($message);

		return $message;
	}

	private function constructResponse(GuzzleResponse $response, $to)
	{
		return new Response($response, $to);
	}

	private function post($url, $tokens, $options, $notification, $data)
	{
		$request = $this->buildRequest($tokens, $options, $notification, $data);
		$requestResponse = $this->client->post($url, $request);
		$response = $this->constructResponse($requestResponse, $tokens);

		return $response;
	}
}