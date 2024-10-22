<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientsRepository::class)]
class Clients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['clients.index', 'clients.show'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['clients.index', 'clients.show'])]
    private ?string $client = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['clients.show'])]
    private ?string $adresse = null;

    #[ORM\Column]
    #[Groups(['clients.show'])]
    private ?int $code_postal = null;

    #[ORM\Column(length: 255)]
    #[Groups(['clients.show'])]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    #[Groups(['clients.show'])]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    #[Groups(['clients.show'])]
    private ?string $civilite = null;

    #[ORM\Column(length: 255)]
    #[Groups(['clients.show'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['clients.show'])]
    private ?string $nom = null;

    /**
     * @var Collection<int, Ventes>
     */
    #[ORM\OneToMany(targetEntity: Ventes::class, mappedBy: 'client', orphanRemoval: true)]
    private Collection $ventes;

    public function __construct()
    {
        $this->ventes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(string $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    public function setCodePostal(int $code_postal): static
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): static
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

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
            $vente->setClient($this);
        }

        return $this;
    }

    public function removeVente(Ventes $vente): static
    {
        if ($this->ventes->removeElement($vente)) {
            // set the owning side to null (unless already changed)
            if ($vente->getClient() === $this) {
                $vente->setClient(null);
            }
        }

        return $this;
    }
}
