<?php

namespace App\Entity;

use App\Entity\Movie;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * 
 * @ORM\Entity(repositoryClass=CategoryRepository::class)   
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"movie_browse","category_browse","movies_search","movie_read","list_movie_add","list_movie_show"})
     * @Assert\NotBlank(message="Category must have a name")
     * @Assert\Regex(
     *              pattern="/[a-z]+/"
     *            )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"movie_browse","category_browse","movies_search","movie_read"})
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity=Movie::class, mappedBy="categories")
     * @Groups({"category_read"})
     * @Assert\Valid
     */
    private $movies;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="categories")
     */
    private $owner;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="favoriteCategories")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity=Mood::class, mappedBy="categories")
     */
    private $moods;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->moods = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Movie[]
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): self
    {
        if (!$this->movies->contains($movie)) {
            $this->movies[] = $movie;
            $movie->addCategory($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->removeElement($movie)) {
            $movie->removeCategory($this);
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addFavoriteCategory($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeFavoriteCategory($this);
        }

        return $this;
    }

    /**
     * @return Collection|Mood[]
     */
    public function getMoods(): Collection
    {
        return $this->moods;
    }

    public function addMood(Mood $mood): self
    {
        if (!$this->moods->contains($mood)) {
            $this->moods[] = $mood;
            $mood->addCategory($this);
        }

        return $this;
    }

    public function removeMood(Mood $mood): self
    {
        if ($this->moods->removeElement($mood)) {
            $mood->removeCategory($this);
        }

        return $this;
    }
}
