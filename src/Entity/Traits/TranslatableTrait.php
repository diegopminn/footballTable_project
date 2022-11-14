<?php
namespace App\Entity\Traits;

use JMS\Serializer\Annotation as Serializer;

/**
 * Trait TranslatableTrait.
 */
trait TranslatableTrait
{
    /**
     * @var array
     */
    private $translates;

    /**
     * @return array
     */
    public function getTranslates()
    {
        return $this->translates;
    }

    /**
     * @param array $translates
     *
     * @return TranslatableTrait
     */
    public function setTranslates($translates)
    {
        $this->translates = $translates;

        return $this;
    }

    /**
     * @param $key
     * @param $translate
     *
     * @return array
     */
    public function addTranslate($key, $translate)
    {
        $this->translates[$key] = $translate;

        return $this->translates;
    }
}
