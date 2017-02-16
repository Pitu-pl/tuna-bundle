<?php

namespace TunaCMS\CommonComponent\Traits;

trait LocaleTrait
{
    /**
     * @var string
     */
    protected $locale;

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