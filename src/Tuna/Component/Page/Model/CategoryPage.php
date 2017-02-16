<?php

namespace TunaCMS\PageComponent\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use TunaCMS\CommonComponent\Traits\AttachmentTrait;
use TunaCMS\CommonComponent\Traits\BodyTrait;
use TunaCMS\CommonComponent\Traits\CategoryTrait;
use TunaCMS\CommonComponent\Traits\GalleryTrait;
use TunaCMS\CommonComponent\Traits\IdTrait;
use TunaCMS\CommonComponent\Traits\ImageTrait;
use TunaCMS\CommonComponent\Traits\LocaleTrait;
use TunaCMS\CommonComponent\Traits\PublishTrait;
use TunaCMS\CommonComponent\Traits\SlugTrait;
use TunaCMS\CommonComponent\Traits\TeaserTrait;
use TunaCMS\CommonComponent\Traits\TimestampTrait;
use TunaCMS\CommonComponent\Traits\TitleTrait;
use TunaCMS\CommonComponent\Traits\TranslateTrait;
use TunaCMS\CommonComponent\Traits\TypeTrait;

/**
 * CategoryPage
 */
abstract class CategoryPage implements CategoryPageInterface
{
    use IdTrait;
    use TypeTrait;
    use SlugTrait;
    use BodyTrait;
    use TitleTrait;
    use ImageTrait;
    use LocaleTrait;
    use TeaserTrait;
    use GalleryTrait;
    use PublishTrait;
    use CategoryTrait;
    use TimestampTrait;
    use TranslateTrait;
    use AttachmentTrait;

    /**
     * CategoryPage constructor.
     */
    public function __construct()
    {
        $this->setAttachments(new ArrayCollection());
        $this->setTranslations(new ArrayCollection());
        $this->setPublished(false);
    }
}