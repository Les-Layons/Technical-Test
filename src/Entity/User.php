<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $lastActionAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="users")
     */
    private $lastActionBy;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="lastActionBy")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity=Offer::class, mappedBy="user", fetch="EXTRA_LAZY")
     */
    private $offers;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->offers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastActionAt(): ?\DateTimeImmutable
    {
        return $this->lastActionAt;
    }

    public function setLastActionAt(\DateTimeImmutable $lastActionAt): self
    {
        $this->lastActionAt = $lastActionAt;

        return $this;
    }

    public function getLastActionBy(): ?self
    {
        return $this->lastActionBy;
    }

    public function setLastActionBy(?self $lastActionBy): self
    {
        $this->lastActionBy = $lastActionBy;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(self $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setLastActionBy($this);
        }

        return $this;
    }

    public function removeUser(self $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getLastActionBy() === $this) {
                $user->setLastActionBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Offer>
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
            $offer->addUser($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->removeElement($offer)) {
            $offer->removeUser($this);
        }

        return $this;
    }
}
