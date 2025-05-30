<?php

namespace App\Entity;

use App\Repository\RECOMMANDATIONSIARepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RECOMMANDATIONSIARepository::class)]
class RECOMMANDATIONSIA
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, UTILISATEURS>
     */
    #[ORM\OneToMany(targetEntity: UTILISATEURS::class, mappedBy: 'recommandations')]
    private Collection $utilisateur_id;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $suggestion = null;

    #[ORM\Column]
    private ?bool $accepte = null;

    #[ORM\Column]
    private ?\DateTime $date_creation = null;

    #[ORM\Column]
    private ?\DateTime $date_modification = null;

    public function __construct()
    {
        $this->utilisateur_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, UTILISATEURS>
     */
    public function getUtilisateurId(): Collection
    {
        return $this->utilisateur_id;
    }

    public function addUtilisateurId(UTILISATEURS $utilisateurId): static
    {
        if (!$this->utilisateur_id->contains($utilisateurId)) {
            $this->utilisateur_id->add($utilisateurId);
            $utilisateurId->setRecommandations($this);
        }

        return $this;
    }

    public function removeUtilisateurId(UTILISATEURS $utilisateurId): static
    {
        if ($this->utilisateur_id->removeElement($utilisateurId)) {
            // set the owning side to null (unless already changed)
            if ($utilisateurId->getRecommandations() === $this) {
                $utilisateurId->setRecommandations(null);
            }
        }

        return $this;
    }

    public function getSuggestion(): ?string
    {
        return $this->suggestion;
    }

    public function setSuggestion(string $suggestion): static
    {
        $this->suggestion = $suggestion;

        return $this;
    }

    public function isAccepte(): ?bool
    {
        return $this->accepte;
    }

    public function setAccepte(bool $accepte): static
    {
        $this->accepte = $accepte;

        return $this;
    }

    public function getDateCreation(): ?\DateTime
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTime $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateModification(): ?\DateTime
    {
        return $this->date_modification;
    }

    public function setDateModification(\DateTime $date_modification): static
    {
        $this->date_modification = $date_modification;

        return $this;
    }
}
