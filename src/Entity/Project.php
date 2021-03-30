<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *   collectionOperations={
 *      "get",
 *   },
 *   itemOperations={
 *     "get",
 *     "delete",
 *   }
 * )
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity=SearchIntent::class, mappedBy="project", cascade={"persist", "remove"})
     */
    private Collection $searchIntents;


    /**
     * Project constructor.
     */
    public function __construct()
    {
        $this->searchIntents = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getSearchIntents(): Collection
    {
        return $this->searchIntents;
    }

    /**
     * @param SearchIntent $searchIntent
     * @return $this
     */
    public function addSearchIntent(SearchIntent $searchIntent): self
    {
        if (!$this->searchIntents->contains($searchIntent)) {
            $this->searchIntents[] = $searchIntent;
            $searchIntent->setProject($this);
        }

        return $this;
    }
}
