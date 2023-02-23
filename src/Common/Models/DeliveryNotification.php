<?php

namespace momopsdk\common\Models;

use momopsdk\Common\Models\BaseModel;

class DeliveryNotification extends BaseModel
{
    /**
     * @var string
     */
    protected $notificationMessage;

    /**
     * @return string|null
     */
    public function getnotificationMessage()
    {
        return $this->notificationMessage;
    }

    /**
     * @param string|null $notificationMessage
     *
     */
    public function setnotificationMessage($notificationMessage)
    {
        $this->notificationMessage = $notificationMessage;
        return $this;
    }

    public function jsonSerialize()
    {
        return $this->filterEmpty([
            'notificationMessage' => $this->notificationMessage,
        ]);
    }
}
