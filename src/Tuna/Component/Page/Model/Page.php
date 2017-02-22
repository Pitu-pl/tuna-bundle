<?php

namespace TunaCMS\PageComponent\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Resource\Model\ResourceInterface;
use TunaCMS\CommonComponent\Traits\AliasTrait;
use TunaCMS\CommonComponent\Traits\BodyTrait;
use TunaCMS\CommonComponent\Traits\IdTrait;
use TunaCMS\CommonComponent\Traits\LocaleTrait;
use TunaCMS\CommonComponent\Traits\PublishTrait;
use TunaCMS\CommonComponent\Traits\SlugTrait;
use TunaCMS\CommonComponent\Traits\TeaserTrait;
use TunaCMS\CommonComponent\Traits\TimestampTrait;
use TunaCMS\CommonComponent\Traits\TitleTrait;
use TunaCMS\CommonComponent\Traits\TranslateTrait;
use TunaCMS\CommonComponent\Traits\TypeTrait;

abstract class Page implements PageInterface, ResourceInterface
{
    use IdTrait;
    use TypeTrait;
    use SlugTrait;
    use BodyTrait;
    use TitleTrait;
    use AliasTrait;
    use LocaleTrait;
    use TeaserTrait;
    use PublishTrait;
    use TimestampTrait;
    use TranslateTrait;

    /**
     * Page constructor.
     */
    public function __construct()
    {
        $this->setTranslations(new ArrayCollection());
        $this->setPublished(false);
    }
}