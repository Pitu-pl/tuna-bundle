<?php

namespace TheCodeine\PageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use TunaCMS\PageComponent\Model\Page as BasePage;

/**
 * Page
 *
 * @ORM\MappedSuperclass
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