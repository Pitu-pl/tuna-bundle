<?php

namespace TunaCMS\CommonComponent\Trait;

use Doctrine\Common\Collections\ArrayCollection;

trait TranslatableTrait
{
    /**
     * @var ArrayCollection
     */
    protected $translations;

    /**
     * {@inheritdoc}
     */
    public function setTranslations(ArrayCollection $translations)
    {
        foreach ($translations as $translation) {
            $translation->setObject($this);
        }

        $this->translations = $translations;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * {@inheritdoc}
     */
    public function addTranslation(AbstractPersonalTranslation $translation)
    {
        if (!$this->translations->contains($translation) && $translation->getContent()) {
            $translation->setObject($this);
            $this->translations->add($translation);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeTranslation(AbstractPersonalTranslation $translation)
    {
        $this->translations->removeElement($translation);

        return $this;
    }
}