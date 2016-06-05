<?php namespace LaravelFCM\Message;


use Illuminate\Contracts\Support\Arrayable;

class Options implements Arrayable {

	protected $collapseKey;
	protected $priority;
	protected $contentAvailable;
	protected $delayWhileIdle;
	protected $timeToLive;
	protected $restrictedPackageName;
	protected $mocking = false;

	public function __construct(OptionsBuilder $builder)
	{
		$this->collapseKey = $builder->getCollapseKey();
		$this->priority =  $builder->getPriority();
		$this->contentAvailable = $builder->isContentAvailable();
		$this->delayWhileIdle = $builder->isDelayWhileIdle();
		$this->timeToLive = $builder->getTimeToLive();
		$this->restrictedPackageName = $builder->getRestrictedPackageName();
		$this->mocking = $builder->isDryRun();
	}

	function toArray()
	{
		$contentAvailable = $this->contentAvailable ? true : null;
		$delayWhileIdle = $this->delayWhileIdle ? true : null;
		$dryRun = $this->mocking ? true : null;

		return [
			'collapse_key' => $this->collapseKey,
		    'priority' => $this->priority,
		    'content_available' => $contentAvailable,
		    'delay_while_idle' => $delayWhileIdle,
		    'time_to_live' => $this->timeToLive,
		    'restricted_package_name' => $this->restrictedPackageName,
		    'dry_run' => $dryRun
		];
	}
}