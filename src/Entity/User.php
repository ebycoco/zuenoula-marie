<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @Vich\Uploadable
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, Serializable
{
    const SEXE = [
        0 => 'M',
        1 => 'Mme',
        2 => 'Mlle',
        3 => 'M et Mme'
    ];
    const PERSONNEL = [
        0 => 'NON',
        1 => 'OUI',
    ];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $youtube;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $instagrame;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $personnel;

    /**
     * @ORM\OneToMany(targetEntity=Service::class, mappedBy="user", orphanRemoval=true)
     */
    private $services;

    /**
     * @ORM\OneToMany(targetEntity=Coin::class, mappedBy="user", orphanRemoval=true)
     */
    private $coins;

    /**
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="user", orphanRemoval=true)
     */
    private $videos;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="user", orphanRemoval=true)
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity=Flash::class, mappedBy="user", orphanRemoval=true)
     */
    private $flashes;

    /**
     * @ORM\OneToMany(targetEntity=Motmaire::class, mappedBy="user", orphanRemoval=true)
     */
    private $motmaires;

    /**
     * @ORM\OneToMany(targetEntity=Slider::class, mappedBy="user", orphanRemoval=true)
     */
    private $sliders;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToMany(targetEntity=Maire::class, mappedBy="user", orphanRemoval=true)
     */
    private $maires;


    /**
     * @ORM\OneToMany(targetEntity=OrganeDeFonctionnement::class, mappedBy="user", orphanRemoval=true)
     */
    private $organeDeFonctionnements;

    /**
     * @ORM\OneToMany(targetEntity=AdministrationDeMunicipalite::class, mappedBy="user", orphanRemoval=true)
     */
    private $administrationDeMunicipalites;

    /**
     * @ORM\OneToMany(targetEntity=FonctionnementMunicipale::class, mappedBy="user", orphanRemoval=true)
     */
    private $fonctionnementMunicipales;

    /**
     * @ORM\OneToMany(targetEntity=Sport::class, mappedBy="user", orphanRemoval=true)
     */
    private $sports;

    /**
     * @ORM\OneToMany(targetEntity=ImageSport::class, mappedBy="user", orphanRemoval=true)
     */
    private $imageSports;

    /**
     * @ORM\OneToMany(targetEntity=HotelRestaurant::class, mappedBy="user", orphanRemoval=true)
     */
    private $hotelRestaurants;

    /**
     * @ORM\OneToMany(targetEntity=GrandeSurface::class, mappedBy="user", orphanRemoval=true)
     */
    private $grandeSurfaces;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isValide;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="utilisateurs", fileNameProperty="imageName")
     * @Assert\Image(maxSize = "8M")
     * 
     *  
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profession;

    /**
     * @ORM\Column(type="boolean")
     */
    private $modif = false;

    /**
     * @ORM\OneToMany(targetEntity=PresentationMairie::class, mappedBy="user", orphanRemoval=true)
     */
    private $presentationMairies;

    /**
     * @ORM\OneToMany(targetEntity=Municipalite::class, mappedBy="user", orphanRemoval=true)
     */
    private $municipalites;

    /**
     * @ORM\OneToMany(targetEntity=InfoService::class, mappedBy="user", orphanRemoval=true)
     */
    private $infoServices;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->coins = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->flashes = new ArrayCollection();
        $this->motmaires = new ArrayCollection();
        $this->sliders = new ArrayCollection();
        $this->maires = new ArrayCollection();
        $this->organeDeFonctionnements = new ArrayCollection();
        $this->administrationDeMunicipalites = new ArrayCollection();
        $this->fonctionnementMunicipales = new ArrayCollection();
        $this->sports = new ArrayCollection();
        $this->imageSports = new ArrayCollection();
        $this->hotelRestaurants = new ArrayCollection();
        $this->grandeSurfaces = new ArrayCollection();
        $this->presentationMairies = new ArrayCollection();
        $this->municipalites = new ArrayCollection();
        $this->infoServices = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getUsername();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getSexe(): ?int
    {
        return $this->sexe;
    }

    public function setSexe(?int $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    public function setYoutube(?string $youtube): self
    {
        $this->youtube = $youtube;

        return $this;
    }

    public function getInstagrame(): ?string
    {
        return $this->instagrame;
    }

    public function setInstagrame(?string $instagrame): self
    {
        $this->instagrame = $instagrame;

        return $this;
    }

    public function getPersonnel(): ?bool
    {
        return $this->personnel;
    }

    public function setPersonnel(?bool $personnel): self
    {
        $this->personnel = $personnel;

        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
            $service->setUser($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getUser() === $this) {
                $service->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Coin[]
     */
    public function getCoins(): Collection
    {
        return $this->coins;
    }

    public function addCoin(Coin $coin): self
    {
        if (!$this->coins->contains($coin)) {
            $this->coins[] = $coin;
            $coin->setUser($this);
        }

        return $this;
    }

    public function removeCoin(Coin $coin): self
    {
        if ($this->coins->removeElement($coin)) {
            // set the owning side to null (unless already changed)
            if ($coin->getUser() === $this) {
                $coin->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setUser($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getUser() === $this) {
                $video->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setUser($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getUser() === $this) {
                $article->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Flash[]
     */
    public function getFlashes(): Collection
    {
        return $this->flashes;
    }

    public function addFlash(Flash $flash): self
    {
        if (!$this->flashes->contains($flash)) {
            $this->flashes[] = $flash;
            $flash->setUser($this);
        }

        return $this;
    }

    public function removeFlash(Flash $flash): self
    {
        if ($this->flashes->removeElement($flash)) {
            // set the owning side to null (unless already changed)
            if ($flash->getUser() === $this) {
                $flash->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Motmaire[]
     */
    public function getMotmaires(): Collection
    {
        return $this->motmaires;
    }

    public function addMotmaire(Motmaire $motmaire): self
    {
        if (!$this->motmaires->contains($motmaire)) {
            $this->motmaires[] = $motmaire;
            $motmaire->setUser($this);
        }

        return $this;
    }

    public function removeMotmaire(Motmaire $motmaire): self
    {
        if ($this->motmaires->removeElement($motmaire)) {
            // set the owning side to null (unless already changed)
            if ($motmaire->getUser() === $this) {
                $motmaire->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Slider[]
     */
    public function getSliders(): Collection
    {
        return $this->sliders;
    }

    public function addSlider(Slider $slider): self
    {
        if (!$this->sliders->contains($slider)) {
            $this->sliders[] = $slider;
            $slider->setUser($this);
        }

        return $this;
    }

    public function removeSlider(Slider $slider): self
    {
        if ($this->sliders->removeElement($slider)) {
            // set the owning side to null (unless already changed)
            if ($slider->getUser() === $this) {
                $slider->setUser(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection|Maire[]
     */
    public function getMaires(): Collection
    {
        return $this->maires;
    }

    public function addMaire(Maire $maire): self
    {
        if (!$this->maires->contains($maire)) {
            $this->maires[] = $maire;
            $maire->setUser($this);
        }

        return $this;
    }

    public function removeMaire(Maire $maire): self
    {
        if ($this->maires->removeElement($maire)) {
            // set the owning side to null (unless already changed)
            if ($maire->getUser() === $this) {
                $maire->setUser(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection|OrganeDeFonctionnement[]
     */
    public function getOrganeDeFonctionnements(): Collection
    {
        return $this->organeDeFonctionnements;
    }

    public function addOrganeDeFonctionnement(OrganeDeFonctionnement $organeDeFonctionnement): self
    {
        if (!$this->organeDeFonctionnements->contains($organeDeFonctionnement)) {
            $this->organeDeFonctionnements[] = $organeDeFonctionnement;
            $organeDeFonctionnement->setUser($this);
        }

        return $this;
    }

    public function removeOrganeDeFonctionnement(OrganeDeFonctionnement $organeDeFonctionnement): self
    {
        if ($this->organeDeFonctionnements->removeElement($organeDeFonctionnement)) {
            // set the owning side to null (unless already changed)
            if ($organeDeFonctionnement->getUser() === $this) {
                $organeDeFonctionnement->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AdministrationDeMunicipalite[]
     */
    public function getAdministrationDeMunicipalites(): Collection
    {
        return $this->administrationDeMunicipalites;
    }

    public function addAdministrationDeMunicipalite(AdministrationDeMunicipalite $administrationDeMunicipalite): self
    {
        if (!$this->administrationDeMunicipalites->contains($administrationDeMunicipalite)) {
            $this->administrationDeMunicipalites[] = $administrationDeMunicipalite;
            $administrationDeMunicipalite->setUser($this);
        }

        return $this;
    }

    public function removeAdministrationDeMunicipalite(AdministrationDeMunicipalite $administrationDeMunicipalite): self
    {
        if ($this->administrationDeMunicipalites->removeElement($administrationDeMunicipalite)) {
            // set the owning side to null (unless already changed)
            if ($administrationDeMunicipalite->getUser() === $this) {
                $administrationDeMunicipalite->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FonctionnementMunicipale[]
     */
    public function getFonctionnementMunicipales(): Collection
    {
        return $this->fonctionnementMunicipales;
    }

    public function addFonctionnementMunicipale(FonctionnementMunicipale $fonctionnementMunicipale): self
    {
        if (!$this->fonctionnementMunicipales->contains($fonctionnementMunicipale)) {
            $this->fonctionnementMunicipales[] = $fonctionnementMunicipale;
            $fonctionnementMunicipale->setUser($this);
        }

        return $this;
    }

    public function removeFonctionnementMunicipale(FonctionnementMunicipale $fonctionnementMunicipale): self
    {
        if ($this->fonctionnementMunicipales->removeElement($fonctionnementMunicipale)) {
            // set the owning side to null (unless already changed)
            if ($fonctionnementMunicipale->getUser() === $this) {
                $fonctionnementMunicipale->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sport[]
     */
    public function getSports(): Collection
    {
        return $this->sports;
    }

    public function addSport(Sport $sport): self
    {
        if (!$this->sports->contains($sport)) {
            $this->sports[] = $sport;
            $sport->setUser($this);
        }

        return $this;
    }

    public function removeSport(Sport $sport): self
    {
        if ($this->sports->removeElement($sport)) {
            // set the owning side to null (unless already changed)
            if ($sport->getUser() === $this) {
                $sport->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ImageSport[]
     */
    public function getImageSports(): Collection
    {
        return $this->imageSports;
    }

    public function addImageSport(ImageSport $imageSport): self
    {
        if (!$this->imageSports->contains($imageSport)) {
            $this->imageSports[] = $imageSport;
            $imageSport->setUser($this);
        }

        return $this;
    }

    public function removeImageSport(ImageSport $imageSport): self
    {
        if ($this->imageSports->removeElement($imageSport)) {
            // set the owning side to null (unless already changed)
            if ($imageSport->getUser() === $this) {
                $imageSport->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|HotelRestaurant[]
     */
    public function getHotelRestaurants(): Collection
    {
        return $this->hotelRestaurants;
    }

    public function addHotelRestaurant(HotelRestaurant $hotelRestaurant): self
    {
        if (!$this->hotelRestaurants->contains($hotelRestaurant)) {
            $this->hotelRestaurants[] = $hotelRestaurant;
            $hotelRestaurant->setUser($this);
        }

        return $this;
    }

    public function removeHotelRestaurant(HotelRestaurant $hotelRestaurant): self
    {
        if ($this->hotelRestaurants->removeElement($hotelRestaurant)) {
            // set the owning side to null (unless already changed)
            if ($hotelRestaurant->getUser() === $this) {
                $hotelRestaurant->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GrandeSurface[]
     */
    public function getGrandeSurfaces(): Collection
    {
        return $this->grandeSurfaces;
    }

    public function addGrandeSurface(GrandeSurface $grandeSurface): self
    {
        if (!$this->grandeSurfaces->contains($grandeSurface)) {
            $this->grandeSurfaces[] = $grandeSurface;
            $grandeSurface->setUser($this);
        }

        return $this;
    }

    public function removeGrandeSurface(GrandeSurface $grandeSurface): self
    {
        if ($this->grandeSurfaces->removeElement($grandeSurface)) {
            // set the owning side to null (unless already changed)
            if ($grandeSurface->getUser() === $this) {
                $grandeSurface->setUser(null);
            }
        }

        return $this;
    }

    public function getIsValide(): ?bool
    {
        return $this->isValide;
    }

    public function setIsValide(bool $isValide): self
    {
        $this->isValide = $isValide;

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
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getModif(): ?bool
    {
        return $this->modif;
    }

    public function setModif(bool $modif): self
    {
        $this->modif = $modif;

        return $this;
    }

    /**
     * @return Collection|PresentationMairie[]
     */
    public function getPresentationMairies(): Collection
    {
        return $this->presentationMairies;
    }

    public function addPresentationMairy(PresentationMairie $presentationMairy): self
    {
        if (!$this->presentationMairies->contains($presentationMairy)) {
            $this->presentationMairies[] = $presentationMairy;
            $presentationMairy->setUser($this);
        }

        return $this;
    }

    public function removePresentationMairy(PresentationMairie $presentationMairy): self
    {
        if ($this->presentationMairies->removeElement($presentationMairy)) {
            // set the owning side to null (unless already changed)
            if ($presentationMairy->getUser() === $this) {
                $presentationMairy->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Municipalite[]
     */
    public function getMunicipalites(): Collection
    {
        return $this->municipalites;
    }

    public function addMunicipalite(Municipalite $municipalite): self
    {
        if (!$this->municipalites->contains($municipalite)) {
            $this->municipalites[] = $municipalite;
            $municipalite->setUser($this);
        }

        return $this;
    }

    public function removeMunicipalite(Municipalite $municipalite): self
    {
        if ($this->municipalites->removeElement($municipalite)) {
            // set the owning side to null (unless already changed)
            if ($municipalite->getUser() === $this) {
                $municipalite->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|InfoService[]
     */
    public function getInfoServices(): Collection
    {
        return $this->infoServices;
    }

    public function addInfoService(InfoService $infoService): self
    {
        if (!$this->infoServices->contains($infoService)) {
            $this->infoServices[] = $infoService;
            $infoService->setUser($this);
        }

        return $this;
    }

    public function removeInfoService(InfoService $infoService): self
    {
        if ($this->infoServices->removeElement($infoService)) {
            // set the owning side to null (unless already changed)
            if ($infoService->getUser() === $this) {
                $infoService->setUser(null);
            }
        }

        return $this;
    }
}