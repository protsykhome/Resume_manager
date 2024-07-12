<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $website = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: ResumeFeedback::class)]
    private Collection $resumeFeedback;

    public function __construct()
    {
        $this->resumeFeedback = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): static
    {
        $this->website = $website;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, ResumeFeedback>
     */
    public function getResumeFeedback(): Collection
    {
        return $this->resumeFeedback;
    }

    public function addResumeFeedback(ResumeFeedback $resumeFeedback): static
    {
        if (!$this->resumeFeedback->contains($resumeFeedback)) {
            $this->resumeFeedback->add($resumeFeedback);
            $resumeFeedback->setCompany($this);
        }

        return $this;
    }

    public function removeResumeFeedback(ResumeFeedback $resumeFeedback): static
    {
        if ($this->resumeFeedback->removeElement($resumeFeedback)) {
            // set the owning side to null (unless already changed)
            if ($resumeFeedback->getCompany() === $this) {
                $resumeFeedback->setCompany(null);
            }
        }

        return $this;
    }
}
