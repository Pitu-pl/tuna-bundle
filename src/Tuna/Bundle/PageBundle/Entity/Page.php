<?php

namespace TheCodeine\PageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use TunaCMS\PageComponent\Model\Page as BasePage;

/**
 * Page
 *
 * @ORM\Table(name="pages")
 * @ORM\Entity(repositoryClass="TheCodeine\PageBundle\Entity\PageRepository")
 * @ORM\EntityListeners({"TheCodeine\PageBundle\EventListener\PageAliasListener"})
 * @ORM\MappedSuperclass()
 * @ORM\HasLifecycleCallbacks
 *
 * @Gedmo\TranslationEntity(class="TheCodeine\PageBundle\Entity\PageTranslation")
 */
class Page extends BasePage
{
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="TheCodeine\PageBundle\Entity\PageTranslation", mappedBy="object", cascade={"persist", "remove"})
     *
     * @Assert\Valid
     */
    protected $translations;
}