<?php

namespace TunaCMS\CommonComponent\Traits;

use Doctrine\ORM\Mapping as ORM;

trait IdTrait
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }
}