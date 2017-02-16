<?php

namespace TunaCMS\CommonComponent\Traits;

use Doctrine\Common\Collections\ArrayCollection;

trait AttachmentTrait
{
    /**
     * @var ArrayCollection
     */
    protected $attachments;

    /**
     * @inheritdoc
     */
    public function setAttachments(ArrayCollection $attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAttachments()
    {
        return $this->attachments;
    }
}