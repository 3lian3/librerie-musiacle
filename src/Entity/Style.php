<?php

namespace App\Entity;

use App\Repository\StyleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StyleRepository::class)]
#[UniqueEntity(
    fields: ["nom"],
    errorPath: "nom",
    message: "Ce nom est déjà utilisé."
)]
#[UniqueEntity(
    fields: ["couleur"],
    errorPath: "couleur",
    message: "Cette couleur est déjà associée à un style."
)]
class Style
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
      private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2, 
        max: 100, 
        minMessage: "Le nom doit contenir au moins {{ limit }} caractères.", 
        maxMessage: "Le nom ne peut contenir plus de {{ limit }} caractères."
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "La couleur est obligatoire.")]
    private ?string $couleur = null;

    #[ORM\ManyToMany(targetEntity: Album::class, mappedBy: 'styles')]
    private Collection $albums;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
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

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * @return Collection<int, Album>
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): static
    {
        if (!$this->albums->contains($album)) {
            $this->albums->add($album);
        }

        return $this;
    }

    public function removeAlbum(Album $album): static
    {
        $this->albums->removeElement($album);

        return $this;
    }
}
