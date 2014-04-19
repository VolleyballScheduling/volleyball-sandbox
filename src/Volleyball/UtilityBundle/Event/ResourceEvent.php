<?php
namespace Volleyball\UtilityBundle\Event;

use Symfony\Component\EventDispatcher\GenericEvent;

class ResourceEvent extends GenericEvent
{
    const TYPE_ERROR    = 'error';
    const TYPE_WARNING  = 'warning';
    const TYPE_INFO     = 'info';
    const TYPE_SUCCESS  = 'success';

    public function stop($message, $type = self::TYPE_ERROR, $parameters = array())
    {
        $this->error = true;
        $this->messageType = $type;
        $this->message = $message;
        $this->messageParameters = $parameters;

        $this->stopPropagation();
    }

    /**
     * Indicate if an error has been detected
     *
     * @var Boolean
     */
    protected $error = false;

    /**
     * Message type
     *
     * @var string
     */
    protected $messageType = '';

    /**
     * Message
     *
     * @var string
     */
    protected $message = '';

    /**
     * Message parameters
     *
     * @var array
     */
    protected $messageParameters = array();

    /**
     * Get error property
     *
     * @return Boolean $error
     */
    public function isStopped()
    {
        return $this->error === true;
    }

    /**
     * Get messageType property
     *
     * @return string $messageType
     */
    public function getMessageType()
    {
        return $this->messageType;
    }

    /**
     * Get message property
     *
     * @return string $message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get messageParameters property
     *
     * @return string $messageParameters
     */
    public function getMessageParameters()
    {
        return $this->messageParameters;
    }
}
