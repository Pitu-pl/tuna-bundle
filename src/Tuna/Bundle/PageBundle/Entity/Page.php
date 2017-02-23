<?php

namespace TheCodeine\PageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
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
use TunaCMS\PageComponent\Model\AbstractPage;

/**
 * @ORM\Table(name="pages")
 * @ORM\EntityListeners({"TheCodeine\PageBundle\EventListener\PageAliasListener"})
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 *
 * @Gedmo\TranslationEntity(class="TheCodeine\PageBundle\Entity\PageTranslation")
 */
class Page extends AbstractPage
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

    public function __construct()
    {
        $this->setTranslations(new ArrayCollection());
        $this->setPublished(false);
    }
}