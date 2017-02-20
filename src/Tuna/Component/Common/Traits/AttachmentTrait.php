<?php

namespace TunaCMS\CommonComponent\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait AttachmentTrait
{
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="TheCodeine\FileBundle\Entity\Attachment", cascade={"persist", "remove"})
     * @ORM\JoinTable(
     *      joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="attachment_id", referencedColumnName="id", unique=true)}
     * )
     * @ORM\OrderBy({"position" = "ASC"})
     *
     * @Assert\Valid
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