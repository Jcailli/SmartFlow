<?php

namespace App\Entity;

use App\Repository\UTILISATEURSRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UTILISATEURSRepository::class)]
class UTILISATEURS implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $mot_de_passe = null;

    #[ORM\Column]
    private ?\DateTime $date_creation = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $expiration_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $token = null;

    #[ORM\Column]
    private ?\DateTime $date_modification = null;

    #[ORM\OneToOne(mappedBy: 'user_id', cascade: ['persist', 'remove'])]
    private ?PREFERENCES $preferences = null;

    /**
     * @var Collection<int, TACHES>
     */
    #[ORM\OneToMany(targetEntity: TACHES::class, mappedBy: 'utilisateur')]
    private Collection $taches;

    /**
     * @var Collection<int, HABITUDESNAVIGATION>
     */
    #[ORM\OneToMany(targetEntity: HABITUDESNAVIGATION::class, mappedBy: 'utilisateur')]
    private Collection $habitudesNavigations;

    /**
     * @var Collection<int, RECOMMANDATIONSIA>
     */
    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: RECOMMANDATIONSIA::class)]
    private Collection $recommandations;

    public function __construct()
    {
        $this->taches = new ArrayCollection();
        $this->habitudesNavigations = new ArrayCollection();
        $this->recommandations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->mot_de_passe;
    }

    public function setMotDePasse(string $mot_de_passe): static
    {
        $this->mot_de_passe = $mot_de_passe;

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

    public function getExpirationDate(): ?\DateTime
    {
        return $this->expiration_date;
    }

    public function setExpirationDate(\DateTime $expiration_date): static
    {
        $this->expiration_date = $expiration_date;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): static
    {
        $this->token = $token;

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

    public function getPreferences(): ?PREFERENCES
    {
        return $this->preferences;
    }

    public function setPreferences(?PREFERENCES $preferences): static
    {
        // unset the owning side of the relation if necessary
        if ($preferences === null && $this->preferences !== null) {
            $this->preferences->setUserId(null);
        }

        // set the owning side of the relation if necessary
        if ($preferences !== null && $preferences->getUserId() !== $this) {
            $preferences->setUserId($this);
        }

        $this->preferences = $preferences;

        return $this;
    }

    /**
     * @return Collection<int, TACHES>
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(TACHES $tach): static
    {
        if (!$this->taches->contains($tach)) {
            $this->taches->add($tach);
            $tach->setUtilisateur($this);
        }

        return $this;
    }

    public function removeTach(TACHES $tach): static
    {
        if ($this->taches->removeElement($tach)) {
            // set the owning side to null (unless already changed)
            if ($tach->getUtilisateur() === $this) {
                $tach->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HABITUDESNAVIGATION>
     */
    public function getHabitudesNavigations(): Collection
    {
        return $this->habitudesNavigations;
    }

    public function addHabitudesNavigation(HABITUDESNAVIGATION $habitudesNavigation): static
    {
        if (!$this->habitudesNavigations->contains($habitudesNavigation)) {
            $this->habitudesNavigations->add($habitudesNavigation);
            $habitudesNavigation->setUtilisateur($this);
        }

        return $this;
    }

    public function removeHabitudesNavigation(HABITUDESNAVIGATION $habitudesNavigation): static
    {
        if ($this->habitudesNavigations->removeElement($habitudesNavigation)) {
            // set the owning side to null (unless already changed)
            if ($habitudesNavigation->getUtilisateur() === $this) {
                $habitudesNavigation->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RECOMMANDATIONSIA>
     */
    public function getRecommandations(): Collection
    {
        return $this->recommandations;
    }

    public function addRecommandation(RECOMMANDATIONSIA $recommandation): static
    {
        if (!$this->recommandations->contains($recommandation)) {
            $this->recommandations->add($recommandation);
            $recommandation->setUtilisateur($this);
        }

        return $this;
    }

    public function removeRecommandation(RECOMMANDATIONSIA $recommandation): static
    {
        if ($this->recommandations->removeElement($recommandation)) {
            // set the owning side to null (unless already changed)
            if ($recommandation->getUtilisateur() === $this) {
                $recommandation->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials()
    {
        // Si tu stockes des données temporaires sensibles, nettoie-les ici
    }

    public function getPassword(): ?string
    {
        return $this->getMotDePasse();
    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }
}
