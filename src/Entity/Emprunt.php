<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use DateInterval;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateEmprunt = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateRetour = null;

    #[ORM\Column(nullable: true)]
    private ?int $fraisRetard = null;

    #[ORM\ManyToMany(targetEntity: Livre::class, inversedBy: 'emprunts')]
    private Collection $livres;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Admin $user = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $dateRetourRetard = null;


    public function __construct()
    {
        $this->livres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEmprunt(): ?\DateTimeImmutable
    {
        return $this->dateEmprunt;
    }

    #[ORM\PrePersist]
    public function setDateEmprunt()
    {
        $this->dateEmprunt = new \DateTimeImmutable();
    }

    public function getDateRetour(): ?\DateTimeImmutable
    {
        return $this->dateRetour;
    }

    #[ORM\PrePersist]
    public function setDateRetour()
    {
        $t = new DateInterval('P2M');
        $dateEmprunt = $this->getDateEmprunt();
        $this->dateRetour = $dateEmprunt->add($t);
    }

    // je ne voulais pas changer car y'avais conflit vec la dateRetour qui s'autoincremente,
    // dansl e fichier html twig, c'est bien date de retour prévu pour l'autoincrementation et date de retour pour la date de retour retard
    public function getDateRetourRetard(): ?\DateTimeImmutable
    {
        return $this->dateRetourRetard;
    }

    public function setDateRetourRetard(?\DateTimeImmutable $dateRetourRetard): self
    {
        $this->dateRetourRetard = $dateRetourRetard;
        return $this;
    }

    public function getFraisRetard(): ?int
    {
        if ($this->dateRetour < $this->dateRetourRetard) {
            $nbJoursRetard = $this->dateRetour->diff($this->dateRetourRetard)->days;
            return $nbJoursRetard;
        }
        return $this->fraisRetard;
    }

    public function setFraisRetard(int $fraisRetard): self
    {
        $this->fraisRetard = 0;
        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(Livre $livre): self
    {
        if (!$this->livres->contains($livre)) {
            $this->livres->add($livre);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        $this->livres->removeElement($livre);

        return $this;
    }


    public function getUser(): ?Admin
    {
        return $this->user;
    }

    public function setUser(?Admin $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
