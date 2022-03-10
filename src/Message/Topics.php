<?php

namespace LaravelFCM\Message;

use Closure;
use LaravelFCM\Message\Exceptions\NoTopicProvidedException;
use LogicException;

/**
 * Create topic or a topic condition
 */
class Topics
{
    /**
     * @internal
     *
     * @var array of element in the condition
     */
    public $conditions = [];

    /**
     * Add a topic, this method should be called before any conditional topic.
     *
     * @param string $first topicName
     *
     * @return self
     */
    public function topic($first)
    {
        $this->conditions[] = [
            'first' => $first,
        ];

        return $this;
    }

    /**
     * Add a or condition to the precedent topic set.
     *
     * Parenthesis is a closure
     *
     * Equivalent of this: **'TopicA' in topic' || 'TopicB' in topics**
     *
     * ```
     *          $topic = new Topics();
     *          $topic->topic('TopicA')
     *                ->orTopic('TopicB');
     * ```
     *
     * Equivalent of this: **'TopicA' in topics && ('TopicB' in topics || 'TopicC' in topics)**
     *
     * ```
     *          $topic = new Topics();
     *          $topic->topic('TopicA')
     *                ->andTopic(function($condition) {
     *                      $condition->topic('TopicB')->orTopic('TopicC');
     *          });
     * ```
     *
     * > Note: Only two operators per expression are supported by fcm
     *
     * @param string|Closure $first topicName or closure
     *
     * @return Topics
     */
    public function orTopic($first)
    {
        return $this->on($first, ' || ');
    }

    /**
     * Add a and condition to the precedent topic set.
     *
     * Parenthesis is a closure
     *
     * Equivalent of this: **'TopicA' in topic' && 'TopicB' in topics**
     *
     * ```
     *          $topic = new Topics();
     *          $topic->topic('TopicA')
     *                ->anTopic('TopicB');
     * ```
     *
     * Equivalent of this: **'TopicA' in topics || ('TopicB' in topics && 'TopicC' in topics)**
     *
     * ```
     *          $topic = new Topics();
     *          $topic->topic('TopicA')
     *                ->orTopic(function($condition) {
     *                      $condition->topic('TopicB')->AndTopic('TopicC');
     *          });
     * ```
     *
     * > Note: Only two operators per expression are supported by fcm
     *
     * @param string|Closure $first topicName or closure
     *
     * @return Topics
     */
    public function andTopic($first)
    {
        return $this->on($first, ' && ');
    }

    /**
     * @internal
     *
     * @param string|Closure $first
     * @param string $condition
     *
     * @return self
     */
    private function on($first, $condition)
    {
        if ($first instanceof Closure) {
            return $this->nest($first, $condition);
        }

        $this->conditions[] = [
            'first' => $first,
            'condition' => $condition,
        ];

        return $this;
    }

    /**
     * @internal
     *
     * @param Closure $callback
     * @param string $condition
     * @param bool $strict Controls if the operators checking is enabled (default to true)
     *
     * @return self
     */
    public function nest(Closure $callback, $condition, $strict = true)
    {
        $topic = new static();

        $callback($topic);
        if (count($topic->conditions)) {
            if ($strict === true && ! in_array(trim($condition, ' '), ['||', '&&'])) {
                throw new LogicException(
                    'You must use either one of \'||\' or \'&&\' as a condition'
                );
            }

            $this->conditions[] = [
                'condition' => $condition,
                'open_parenthesis' => '(',
                'topic' => $topic->conditions,
                'close_parenthesis' => ')',
            ];
        }

        return $this;
    }

    /**
     * Transform to array.
     *
     * @return array|string
     *
     * @throws NoTopicProvidedException
     */
    public function build()
    {
        $this->checkIfOneTopicExist();

        if ($this->hasOnlyOneTopic()) {
            foreach ($this->conditions[0] as $topic) {
                return '/topics/' . $topic;
            }
        }

        return [
            'condition' => $this->topicsForFcm($this->conditions),
        ];
    }

    /**
     * @internal
     *
     * @param array $conditions
     *
     * @return string
     */
    protected function topicsForFcm($conditions)
    {
        $condition = '';
        foreach ($conditions as $partial) {
            if (array_key_exists('condition', $partial)) {
                // Add spaces if they where forgotten, remove them in case they exist
                // And add them back
                $condition .= ' ' . trim($partial['condition'], ' ') . ' ';
            }

            if (array_key_exists('first', $partial)) {
                $topic = $partial['first'];
                $condition .= "'$topic' in topics";
            }

            if (array_key_exists('open_parenthesis', $partial)) {
                $condition .= $partial['open_parenthesis'];
            }

            if (array_key_exists('topic', $partial)) {
                $condition .= $this->topicsForFcm($partial['topic']);
            }

            if (array_key_exists('close_parenthesis', $partial)) {
                $condition .= $partial['close_parenthesis'];
            }
        }

        return $condition;
    }

    /**
     * Check if only one topic was set.
     *
     * @return bool
     */
    public function hasOnlyOneTopic()
    {
        return count($this->conditions) == 1;
    }

    /**
     * @internal
     *
     * @throws NoTopicProvidedException
     * @return void
     */
    protected function checkIfOneTopicExist()
    {
        if (!count($this->conditions)) {
            throw new NoTopicProvidedException('At least one topic must be provided');
        }
    }
}
