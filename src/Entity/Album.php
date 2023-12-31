<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
#[UniqueEntity(
    fields: ["nom", "artiste"],
    message: "Ce nom est déjà utilisé."
)]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 1, 
        max: 100, 
        minMessage: "Le nom doit contenir au moins {{ limit }} caractères.", 
        maxMessage: "Le nom ne peut contenir plus de {{ limit }} caractères."
    )]
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    private ?string $nom = null;

    #[ORM\Column]
    #[assert\Range(
        min: 1900, 
        max: 2999, 
        notInRangeMessage: "La date doit être comprise entre {{ min }} et {{ max }}.",
        invalidMessage: "La date doit être un nombre."
    )]
    private ?int $date = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'albums')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "L'artiste est obligatoire.")]
    private ?Artiste $artiste = null;

    #[ORM\OneToMany(mappedBy: 'album', targetEntity: Morceau::class, cascade:['persist', 'remove'], orphanRemoval:true)]
    private Collection $morceaux;

    #[ORM\ManyToMany(targetEntity: Style::class, inversedBy: 'albums')]
    #[Assert\Count(min: 1, minMessage: "Au moins un style doit être sélectionné.")]
    private Collection $styles;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->morceaux = new ArrayCollection();
        $this->styles = new ArrayCollection();
        $this->setUpdatedAt(new \DateTimeImmutable());
        $this->setImage("pochetteAlbum.jpg");
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

    public function getDate(): ?int
    {
        return $this->date;
    }

    public function setDate(int $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getArtiste(): ?Artiste
    {
        return $this->artiste;
    }

    public function setArtiste(?Artiste $artiste): static
    {
        $this->artiste = $artiste;

        return $this;
    }

    /**
     * @return Collection<int, Morceau>
     */
    public function getMorceaux(): Collection
    {
        return $this->morceaux;
    }

    public function addMorceau(Morceau $morceau): static
    {
        if (!$this->morceaux->contains($morceau)) {
            $this->morceaux[] = $morceau;
            $morceau->setAlbum($this);
        }

        return $this;
    }

    public function removeMorceau(Morceau $morceau): static
    {
        if ($this->morceaux->contains($morceau)) {
            $this->morceaux->removeElement($morceau); 
            // set the owning side to null (unless already changed)
            if ($morceau->getAlbum() === $this) {
                $morceau->setAlbum(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Style>
     */
    public function getStyles(): Collection
    {
        return $this->styles;
    }

    public function addStyle(Style $style): static
    {
        if (!$this->styles->contains($style)) {
            $this->styles->add($style);
            $style->addAlbum($this);
        }

        return $this;
    }

    public function removeStyle(Style $style): static
    {
        if ($this->styles->removeElement($style)) {
            $style->removeAlbum($this);
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
