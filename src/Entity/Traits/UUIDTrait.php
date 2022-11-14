<?php
namespace App\Entity\Traits;

use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait UUIDTrait
 * @package App\Entity\Traits
 * @ORM\HasLifecycleCallbacks()
 */
trait UUIDTrait
{
    /**
     * @var string
     * @ORM\Column(name="uuid", type="string", length=255, nullable=true)
     */
    private $uuid;

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     *
     * @return $this
     */
    public function setUuid(string $uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @ORM\PreFlush()
     *
     * @param PreFlushEventArgs $eventArgs
     *
     * @throws \Exception
     */
    public function onPreFlush(PreFlushEventArgs $eventArgs)
    {
        if (null == $this->getId() || null == $this->getUuid()) {
            $this->setUuid(rtrim(chunk_split(strtolower(bin2hex(random_bytes(7))), 5, '-'), '-'));
        }
    }
}
