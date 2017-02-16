<?php

namespace TunaCMS\CommonComponent\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

interface TranslateInterface
{
    /**
     * @param ArrayCollection $translations
     *
     * @return self
     */
    public function setTranslations(ArrayCollection $translations);

    /**
     * @return ArrayCollection
     */
    public function getTranslations();

    /**
     * @param AbstractPersonalTranslation $translation
     *
     * @return self
     */
    public function addTranslation(AbstractPersonalTranslation $translation);

    /**
     * @param AbstractPersonalTranslation $translation
     *
     * @return self
     */
    public function removeTranslation(AbstractPersonalTranslation $translation);
}