<?php namespace LaravelFCM\Message;


class PayloadDataBuilder {

	protected $data;

	/**
	 * Form more information about options, please refer to google official documentation :
	 * @link http://firebase.google.com/docs/cloud-messaging/http-server-ref#downstream-http-messages-json
	 */
	public function __construct()
	{
	}

	/**
	 * add data to existing data
	 *
	 * @param array $data
	 */
	public function addData(array $data)
	{
		$this->data = $this->data ?: [];

		$this->data = array_merge($data, $this->data);
	}

	/**
	 * erase data with new data
	 *
	 * @param array $data
	 */
	public function setData(array $data)
	{
		$this->data = $data;
	}

	/**
	 * Remove all data
	 */
	public function removeAllData()
	{
		$this->data = null;
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * @return PayloadData new PayloadData instance
	 */
	public function build()
	{
		return new PayloadData($this);
	}
}