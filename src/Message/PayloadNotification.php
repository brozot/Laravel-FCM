<?php namespace LaravelFCM\Message;


use Illuminate\Contracts\Support\Arrayable;

class PayloadNotification implements Arrayable {

	protected $title;
	protected $body;
	protected $icon;
	protected $sound;
	protected $badge;
	protected $tag;
	protected $color;
	protected $clickAction;
	protected $bodyLocationKey;
	protected $bodyLocationArgs;
	protected $titleLocationKey;
	protected $titleLocationArgs;

	public function __construct(PayloadNotificationBuilder $builder)
	{
		$this->title = $builder->getTitle();
		$this->body = $builder->getBody();
		$this->icon = $builder->getIcon();
		$this->sound = $builder->getSound();
		$this->badge = $builder->getBadge();
		$this->tag = $builder->getTag();
		$this->color = $builder->getColor();
		$this->clickAction = $builder->getClickAction();
		$this->bodyLocationKey = $builder->getBodyLocationKey();
		$this->bodyLocationArgs = $builder->getBodyLocationArgs();
		$this->titleLocationKey = $builder->getTitleLocationKey();
		$this->titleLocationArgs = $builder->getTitleLocationArgs();

	}

	function toArray()
	{
		$notification = [
			'title' => $this->title,
		    'body' => $this->body,
		    'icon' => $this->icon,
		    'sound' => $this->sound,
		    'badge' => $this->badge,
		    'tag' => $this->tag,
		    'color' => $this->color,
		    'click_action' => $this->clickAction,
		    'body_loc_key' => $this->bodyLocationKey,
		    'body_loc_args' => $this->bodyLocationArgs,
		    'title_loc_key' => $this->titleLocationKey,
			'title_loc_args' => $this->titleLocationArgs,
		];

		// remove null values
		$notification = array_filter($notification);

		return $notification;
	}
}