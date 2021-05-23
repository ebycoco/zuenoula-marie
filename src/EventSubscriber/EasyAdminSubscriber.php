<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\AdministrationDeMunicipalite;
use App\Entity\Article;
use App\Entity\Coin;
use App\Entity\Flash;
use App\Entity\FonctionnementMunicipale;
use App\Entity\ImageSport;
use App\Entity\Maire;
use App\Entity\Motmaire;
use App\Entity\OrganeDeFonctionnement;
use App\Entity\PresentationMairie;
use App\Entity\Service;
use App\Entity\Slider;
use App\Entity\Sport;
use App\Entity\Video;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $slugger;
    private $security;

    /**
     *  __Construct method
     * @param $slugger
     */
    public function __construct(SluggerInterface $slugger, Security $security)
    {
        $this->slugger = $slugger;
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setUser'],
        ];
    }
    public function setUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();
        if ($entity instanceof Article) {
            $user = $this->security->getUser();
            $entity->setUser($user);
        }
        if ($entity instanceof Flash) {
            $user = $this->security->getUser();
            $entity->setUser($user);
        }
        if ($entity instanceof Motmaire) {
            $user = $this->security->getUser();
            $entity->setUser($user);
        }
        if ($entity instanceof Coin) {
            $user = $this->security->getUser();
            $entity->setUser($user);
        }
        if ($entity instanceof Slider) {
            $user = $this->security->getUser();
            $entity->setUser($user);
        }
        if ($entity instanceof Service) {
            $user = $this->security->getUser();
            $entity->setUser($user);
        }
        if ($entity instanceof Video) {
            $user = $this->security->getUser();
            $entity->setUser($user);
        }
        if ($entity instanceof Motmaire) {
            $user = $this->security->getUser();
            $entity->setUser($user);
        }
        if ($entity instanceof Maire) {
            $user = $this->security->getUser();
            $entity->setUser($user);
        }
        if ($entity instanceof PresentationMairie) {
            $user = $this->security->getUser();
            $entity->setUser($user);
        }
        if ($entity instanceof OrganeDeFonctionnement) {
            $user = $this->security->getUser();
            $entity->setUser($user);
        }
        if ($entity instanceof AdministrationDeMunicipalite) {
            $user = $this->security->getUser();
            $entity->setUser($user);
        }
        if ($entity instanceof PresentationMairie) {
            $user = $this->security->getUser();
            $entity->setUser($user);
        }
        if ($entity instanceof FonctionnementMunicipale) {
            $user = $this->security->getUser();
            $entity->setUser($user);
        }
        if ($entity instanceof Sport) {
            $user = $this->security->getUser();
            $entity->setUser($user);
        }
        if ($entity instanceof ImageSport) {
            $user = $this->security->getUser();
            $entity->setUser($user);
        }
        return;
    }
}