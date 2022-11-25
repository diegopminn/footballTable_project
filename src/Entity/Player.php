<?php

namespace App\Entity;

use App\Entity\Traits\StatusTrait;
use App\Entity\Traits\UUIDTrait;
use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
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
     * @return Player
     */
    public function setId ( ?int $id ): Player
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
     * @return Player
     */
    public function setname ( ?string $name ): Player
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
     * @return Player
     */
    public function setBluesForward ( ?Game $bluesForward ): Player
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
     * @return Player
     */
    public function setRedsDefense ( ?Game $redsDefense ): Player
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
     * @return Player
     */
    public function setRedsForward ( ?Game $redsForward ): Player
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
     * @return Player
     */
    public function setBluesDefense ( ?Game $bluesDefense ): Player
    {
        $this->bluesDefense = $bluesDefense;
        return $this;
    }

    public function __toString (): string
    {
        return $this->name;
    }
}
