<?php

namespace TheCodeine\NewsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use TheCodeine\PageBundle\Entity\BasePage;

/**
 * News
 *
 * @ORM\Entity(repositoryClass="TheCodeine\NewsBundle\Entity\NewsRepository")
 */
class News extends BaseNews
{
}