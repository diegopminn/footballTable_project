<?php

namespace App\Entity;

use App\Entity\Traits\StatusTrait;
use App\Entity\Traits\UUIDTrait;
use App\Repository\PlayerrRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PlayerrRepository::class)
 */
class Playerr
{
    use StatusTrait, UUIDTrait;

    /**
     * @var null|int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var null|string
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var null|Gamee
     * @ORM\OneToMany(targetEntity=Gamee::class, mappedBy="blueForward")
     */
    private $bluesForward;

    /**
     * @var null|Gamee
     * @ORM\OneToMany(targetEntity=Gamee::class, mappedBy="redDefense")
     */
    private $redsDefense;

    /**
     * @var null|Gamee
     * @ORM\OneToMany(targetEntity=Gamee::class, mappedBy="redForward")
     */
    private $redsForward;

    /**
     * @var null|Gamee
     * @ORM\OneToMany(targetEntity=Gamee::class, mappedBy="blueDefense")
     */
    private $bluesDefense;

    /**
     * @return int|null
     */
    public function getId (): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Playerr
     */
    public function setId ( ?int $id ): Playerr
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getname (): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Playerr
     */
    public function setname ( ?string $name ): Playerr
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Gamee|null
     */
    public function getBluesForward (): ?Gamee
    {
        return $this->bluesForward;
    }

    /**
     * @param Gamee|null $bluesForward
     * @return Playerr
     */
    public function setBluesForward ( ?Gamee $bluesForward ): Playerr
    {
        $this->bluesForward = $bluesForward;
        return $this;
    }

    /**
     * @return Gamee|null
     */
    public function getRedsDefense (): ?Gamee
    {
        return $this->redsDefense;
    }

    /**
     * @param Gamee|null $redsDefense
     * @return Playerr
     */
    public function setRedsDefense ( ?Gamee $redsDefense ): Playerr
    {
        $this->redsDefense = $redsDefense;
        return $this;
    }

    /**
     * @return Gamee|null
     */
    public function getRedsForward (): ?Gamee
    {
        return $this->redsForward;
    }

    /**
     * @param Gamee|null $redsForward
     * @return Playerr
     */
    public function setRedsForward ( ?Gamee $redsForward ): Playerr
    {
        $this->redsForward = $redsForward;
        return $this;
    }

    /**
     * @return Gamee|null
     */
    public function getBluesDefense (): ?Gamee
    {
        return $this->bluesDefense;
    }

    /**
     * @param Gamee|null $bluesDefense
     * @return Playerr
     */
    public function setBluesDefense ( ?Gamee $bluesDefense ): Playerr
    {
        $this->bluesDefense = $bluesDefense;
        return $this;
    }


    public function __toString (): string
    {
        return $this->name;
    }
}
