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
     * @var null|Game
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="blueForward")
     */
    private $bluesForward;

    /**
     * @var null|Game
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="redDefense")
     */
    private $redsDefense;

    /**
     * @var null|Game
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="redForward")
     */
    private $redsForward;

    /**
     * @var null|Game
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="blueDefense")
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
     * @return Game|null
     */
    public function getBluesForward (): ?Game
    {
        return $this->bluesForward;
    }

    /**
     * @param Game|null $bluesForward
     * @return Playerr
     */
    public function setBluesForward ( ?Game $bluesForward ): Playerr
    {
        $this->bluesForward = $bluesForward;
        return $this;
    }

    /**
     * @return Game|null
     */
    public function getRedsDefense (): ?Game
    {
        return $this->redsDefense;
    }

    /**
     * @param Game|null $redsDefense
     * @return Playerr
     */
    public function setRedsDefense ( ?Game $redsDefense ): Playerr
    {
        $this->redsDefense = $redsDefense;
        return $this;
    }

    /**
     * @return Game|null
     */
    public function getRedsForward (): ?Game
    {
        return $this->redsForward;
    }

    /**
     * @param Game|null $redsForward
     * @return Playerr
     */
    public function setRedsForward ( ?Game $redsForward ): Playerr
    {
        $this->redsForward = $redsForward;
        return $this;
    }

    /**
     * @return Game|null
     */
    public function getBluesDefense (): ?Game
    {
        return $this->bluesDefense;
    }

    /**
     * @param Game|null $bluesDefense
     * @return Playerr
     */
    public function setBluesDefense ( ?Game $bluesDefense ): Playerr
    {
        $this->bluesDefense = $bluesDefense;
        return $this;
    }


    public function __toString (): string
    {
        return $this->name;
    }
}
