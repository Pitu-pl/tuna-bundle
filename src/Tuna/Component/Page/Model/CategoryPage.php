<?php

namespace TunaCMS\PageComponent\Model;

use Doctrine\ORM\Mapping as ORM;
use TunaCMS\CommonComponent\Model\CategoryInterface;
use TunaCMS\CommonComponent\Traits\CategoryTrait;

/**
 * @MappedSuperclass
 */
abstract class CategoryPage extends Page implements CategoryInterface
{
    use CategoryTrait;
}