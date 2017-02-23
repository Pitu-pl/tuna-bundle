<?php

namespace TunaCMS\CommonComponent\Traits;

use Gedmo\Mapping\Annotation as Gedmo;

trait LocaleTrait
{
    /**
     * @var string
     *
     * @Gedmo\Locale
     */
    private $locale;

    /**
     * @inheritdoc
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getLocale()
    {
        return $this->locale;
    }
}