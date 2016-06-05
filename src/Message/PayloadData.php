<?php namespace LaravelFCM\Message;


use Illuminate\Contracts\Support\Arrayable;

class PayloadData implements Arrayable{

	protected $data;

	public function __construct(PayloadDataBuilder $builder)
	{
		$this->data = $builder->getData();
	}

	function toArray()
	{
		return $this->data;
	}
}