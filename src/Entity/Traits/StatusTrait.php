<?php
namespace App\Entity\Traits;

use App\Utils\Commons;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait StatusTrait.
 */
trait StatusTrait
{
    /**
     * @var int
     * @ORM\Column(name="`status`", type="smallint", nullable=false)
     * @Assert\NotBlank()
     * @Assert\Choice(choices = {1, 0}, message = "Insert a valid value.")
     */
    protected $status = Commons::STATUS_ACTIVE;

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}
