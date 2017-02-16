<?php

namespace TunaCMS\CommonComponent\Model;

use Doctrine\Common\Collections\ArrayCollection;

interface AttachmentInterface
{
    /**
     * @param ArrayCollection $attachments
     *
     * @return self
     */
    public function setAttachments(ArrayCollection $attachments);

    /**
     * @return ArrayCollection
     */
    public function getAttachments();
}