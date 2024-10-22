<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProduitsRepository::class)]
class Produits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['produits.index', 'produits.show', 'produits.create'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['produits.index', 'produits.show', 'produits.create'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['produits.show', 'produits.create'])]
    private ?string $categorie = null;

    #[ORM\Column(length: 255)]
    #[Groups(['produits.show', 'produits.create'])]
    private ?string $sous_categorie = null;

    #[ORM\Column(length: 255)]
    #[Groups(['produits.show', 'produits.create'])]
    private ?string $cout_unitaire = null;

    #[ORM\Column(length: 255)]
    #[Groups(['produits.show', 'produits.create'])]
    private ?string $prix_unitaire = null;

    /**
     * @var Collection<int, Ventes>
     */
    #[ORM\OneToMany(targetEntity: Ventes::class, mappedBy: 'produit')]
    private Collection $ventes;

    public function __construct()
    {
        $this->ventes = new ArrayCollection();
    }

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

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getSousCategorie(): ?string
    {
        return $this->sous_categorie;
    }

    public function setSousCategorie(string $sous_categorie): static
    {
        $this->sous_categorie = $sous_categorie;

        return $this;
    }

    public function getCoutUnitaire(): ?string
    {
        return $this->cout_unitaire;
    }

    public function setCoutUnitaire(string $cout_unitaire): static
    {
        $this->cout_unitaire = $cout_unitaire;

        return $this;
    }

    public function getPrixUnitaire(): ?string
    {
        return $this->prix_unitaire;
    }

    public function setPrixUnitaire(string $prix_unitaire): static
    {
        $this->prix_unitaire = $prix_unitaire;

        return $this;
    }

    /**
     * @return Collection<int, Ventes>
     */
    public function getVentes(): Collection
    {
        return $this->ventes;
    }

    public function addVente(Ventes $vente): static
    {
        if (!$this->ventes->contains($vente)) {
            $this->ventes->add($vente);
            $vente->setProduit($this);
        }

        return $this;
    }

    public function removeVente(Ventes $vente): static
    {
        if ($this->ventes->removeElement($vente)) {
            // set the owning side to null (unless already changed)
            if ($vente->getProduit() === $this) {
                $vente->setProduit(null);
            }
        }

        return $this;
    }
}
