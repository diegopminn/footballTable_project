<?php

namespace App\Entity;

use App\Repository\GameeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GameeRepository::class)
 */
class Gamee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Playerr::class, inversedBy="bluesForward")
     * @ORM\JoinColumn(nullable=false)
     */
    private $blueForward;

    /**
     * @ORM\ManyToOne(targetEntity=Playerr::class, inversedBy="bluesDefense")
     * @ORM\JoinColumn(nullable=false)
     */
    private $blueDefense;

    /**
     * @ORM\ManyToOne(targetEntity=Playerr::class, inversedBy="redsForward")
     * @ORM\JoinColumn(nullable=false)
     */
    private $redForward;

    /**
     * @ORM\ManyToOne(targetEntity=Playerr::class, inversedBy="redsDefense")
     * @ORM\JoinColumn(nullable=false)
     */
    private $redDefense;

    /**
     * @Assert\Length(min="0")
     * @Assert\Length(max="7")
     * @ORM\Column(type="integer")
     */
    private $blueGols;

    /**
     * @ORM\Column(type="integer")
     */
    private $redGols;

    /**
     * @param $blueForward
     * @param $blueDefense
     * @param $redForward
     * @param $redDefense
     * @param $blueGols
     * @param $redGols
     */
    public function __construct ( $blueForward = null, $blueDefense = null, $redForward = null, $redDefense = null, $blueGols = null, $redGols = null )
    {
        $this->blueForward = $blueForward;
        $this->blueDefense = $blueDefense;
        $this->redForward = $redForward;
        $this->redDefense = $redDefense;
        $this->blueGols = $blueGols;
        $this->redGols = $redGols;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlueForward(): ?Playerr
    {
        return $this->blueForward;
    }

    public function setBlueForward(?Playerr $blueForward): self
    {
        $this->blueForward = $blueForward;

        return $this;
    }

    public function getBlueDefense(): ?Playerr
    {
        return $this->blueDefense;
    }

    public function setBlueDefense(?Playerr $blueDefense): self
    {
        $this->blueDefense = $blueDefense;

        return $this;
    }

    public function getRedForward(): ?Playerr
    {
        return $this->redForward;
    }

    public function setRedForward(?Playerr $redForward): self
    {
        $this->redForward = $redForward;

        return $this;
    }

    public function getRedDefense(): ?Playerr
    {
        return $this->redDefense;
    }

    public function setRedDefense(?Playerr $redDefense): self
    {
        $this->redDefense = $redDefense;

        return $this;
    }

    public function getBlueGols(): ?int
    {
        return $this->blueGols;
    }

    public function setBlueGols(int $blueGols): self
    {
        $this->blueGols = $blueGols;

        return $this;
    }

    public function getRedGols(): ?int
    {
        return $this->redGols;
    }

    public function setRedGols(int $redGols): self
    {
        $this->redGols = $redGols;

        return $this;
    }
}
