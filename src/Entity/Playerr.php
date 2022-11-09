<?php

namespace App\Entity;

use App\Repository\PlayerrRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PlayerrRepository::class)
 */
class Playerr
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\OneToMany(targetEntity=Gamee::class, mappedBy="blueForward")
     */
    private $bluesForward;

    /**
     * @ORM\OneToMany(targetEntity=Gamee::class, mappedBy="redDefense")
     */
    private $redsDefense;

    /**
     * @ORM\OneToMany(targetEntity=Gamee::class, mappedBy="redForward")
     */
    private $redsForward;

    /**
     * @ORM\OneToMany(targetEntity=Gamee::class, mappedBy="blueDefense")
     */
    private $bluesDefense;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection<int, Gamee>
     */
    public function getBluesForward(): Collection
    {
        return $this->bluesForward;
    }

    public function addBluesForward(Gamee $bluesForward): self
    {
        if (!$this->bluesForward->contains($bluesForward)) {
            $this->bluesForward[] = $bluesForward;
            $bluesForward->setBlueForward($this);
        }

        return $this;
    }

    public function removeBluesForward(Gamee $bluesForward): self
    {
        if ($this->bluesForward->removeElement($bluesForward)) {
            // set the owning side to null (unless already changed)
            if ($bluesForward->getBlueForward() === $this) {
                $bluesForward->setBlueForward(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Gamee>
     */
    public function getRedsDefense(): Collection
    {
        return $this->redsDefense;
    }

    public function addRedsDefense(Gamee $redsDefense): self
    {
        if (!$this->redsDefense->contains($redsDefense)) {
            $this->redsDefense[] = $redsDefense;
            $redsDefense->setBlueDefense($this);
        }

        return $this;
    }

    public function removeRedsDefense(Gamee $redsDefense): self
    {
        if ($this->redsDefense->removeElement($redsDefense)) {
            // set the owning side to null (unless already changed)
            if ($redsDefense->getBlueDefense() === $this) {
                $redsDefense->setBlueDefense(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Gamee>
     */
    public function getRedsForward(): Collection
    {
        return $this->redsForward;
    }


    public function addRedsForward(Gamee $redsForward): self
    {
        if (!$this->redsForward->contains($redsForward)) {
            $this->redsForward[] = $redsForward;
            $redsForward->setRedForward($this);
        }

        return $this;
    }

    public function removeRedsForward(Gamee $redsForward): self
    {
        if ($this->redsForward->removeElement($redsForward)) {
            // set the owning side to null (unless already changed)
            if ($redsForward->getRedForward() === $this) {
                $redsForward->setRedForward(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Gamee>
     */
    public function getBluesDefense(): Collection
    {
        return $this->bluesDefense;
    }

    public function addBluesDefense(Gamee $bluesDefense): self
    {
        if (!$this->bluesDefense->contains($bluesDefense)) {
            $this->bluesDefense[] = $bluesDefense;
            $bluesDefense->setRedDefense($this);
        }

        return $this;
    }

    public function removeBluesDefense(Gamee $bluesDefense): self
    {
        if ($this->bluesDefense->removeElement($bluesDefense)) {
            // set the owning side to null (unless already changed)
            if ($bluesDefense->getRedDefense() === $this) {
                $bluesDefense->setRedDefense(null);
            }
        }

        return $this;
    }

    public function __toString (): string
    {
        return $this->Name;
    }
}
