<?php

namespace App\Entity;

use App\Repository\GameeRepository;
use Doctrine\ORM\Mapping as ORM;
use Monolog\DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GameeRepository::class)
 */
class Gamee
{
    /**
     * @var null|int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var null|Gamee
     * @ORM\ManyToOne(targetEntity=Playerr::class, inversedBy="bluesForward")
     * @ORM\JoinColumn(nullable=false)
     */
    private $blueForward;

    /**
     * @var null|Gamee
     * @ORM\ManyToOne(targetEntity=Playerr::class, inversedBy="bluesDefense")
     * @ORM\JoinColumn(nullable=false)
     */
    private $blueDefense;

    /**
     * @var null|Gamee
     * @ORM\ManyToOne(targetEntity=Playerr::class, inversedBy="redsForward")
     * @ORM\JoinColumn(nullable=false)
     */
    private $redForward;

    /**
     * @var null|Gamee
     * @ORM\ManyToOne(targetEntity=Playerr::class, inversedBy="redsDefense")
     * @ORM\JoinColumn(nullable=false)
     */
    private $redDefense;

    /**
     * @var null|int
     * @Assert\Length(min="0")
     * @Assert\Length(max="7")
     * @ORM\Column(type="integer")
     */
    private $blueGols;

    /**
     * @var null|int
     * @ORM\Column(type="integer")
     */
    private $redGols;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file;

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
        $this->createdAt = new \DateTimeImmutable();
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

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt (): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     * @return Gamee
     */
    public function setCreatedAt ( \DateTimeImmutable $createdAt ): Gamee
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;

        return $this;
    }




}
