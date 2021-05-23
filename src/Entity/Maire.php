<?php

namespace App\Entity;

use App\Entity\Traits\TimesTampable;
use App\Repository\MaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MaireRepository::class)
 * @Vich\Uploadable
 * @ORM\Table(name="Zuenoula_maires") 
 * @ORM\HasLifecycleCallbacks
 */
class Maire
{
    use TimesTampable;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomPrenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $proffesion;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $debutFonction;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $finFonction;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="maire", fileNameProperty="imageName")
     * @Assert\Image(maxSize = "8M")
     * 
     *  
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string",nullable=true)
     *
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="maires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPrenom(): ?string
    {
        return $this->nomPrenom;
    }

    public function setNomPrenom(string $nomPrenom): self
    {
        $this->nomPrenom = $nomPrenom;

        return $this;
    }

    public function getProffesion(): ?string
    {
        return $this->proffesion;
    }

    public function setProffesion(?string $proffesion): self
    {
        $this->proffesion = $proffesion;

        return $this;
    }

    public function getDebutFonction(): ?\DateTimeInterface
    {
        return $this->debutFonction;
    }

    public function setDebutFonction(?\DateTimeInterface $debutFonction): self
    {
        $this->debutFonction = $debutFonction;

        return $this;
    }

    public function getFinFonction(): ?\DateTimeInterface
    {
        return $this->finFonction;
    }

    public function setFinFonction(?\DateTimeInterface $finFonction): self
    {
        $this->finFonction = $finFonction;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}