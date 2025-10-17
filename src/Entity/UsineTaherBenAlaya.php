<?php


namespace App\Entity;

use App\Repository\UsineNomPrenomRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsineNomPrenomRepository::class)]
class UsineNomPrenom
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $nbrTotal = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $dateProduction = null;

    #[ORM\Column(type: 'boolean')]
    private bool $statut = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNbrTotal(): ?int
    {
        return $this->nbrTotal;
    }

    public function setNbrTotal(?int $nbrTotal): static
    {
        $this->nbrTotal = $nbrTotal;

        return $this;
    }

    public function getDateProduction(): ?\DateTimeImmutable
    {
        return $this->dateProduction;
    }

    public function setDateProduction(?\DateTimeImmutable $dateProduction): static
    {
        $this->dateProduction = $dateProduction;

        return $this;
    }

    public function isStatut(): bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): static
    {
        $this->statut = $statut;

        return $this;
    }
}