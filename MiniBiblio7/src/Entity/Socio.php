<?php

namespace App\Entity;

use App\Repository\SocioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity(repositoryClass: SocioRepository::class)]
class Socio implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $dni = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $apellidos = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nombre = null;

    #[ORM\Column]
    private ?bool $esDocente = null;

    #[ORM\Column]
    private ?bool $esEstudiante = null;

    #[ORM\Column(length: 255)]
    private ?string $telefono = null;

    #[ORM\OneToMany(targetEntity: libro::class, mappedBy: 'socio')]
    private Collection $libros;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?bool $esAdministrador = null;

    public function __construct()
    {
        $this->libros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): static
    {
        $this->dni = $dni;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(?string $apellidos): static
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function isEsDocente(): ?bool
    {
        return $this->esDocente;
    }

    public function setEsDocente(?bool $esDocente): static
    {
        $this->esDocente = $esDocente;

        return $this;
    }

    public function isEsEstudiante(): ?bool
    {
        return $this->esEstudiante;
    }

    public function setEsEstudiante(bool $esEstudiante): static
    {
        $this->esEstudiante = $esEstudiante;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * @return Collection<int, libro>
     */
    public function getLibros(): Collection
    {
        return $this->libros;
    }

    public function addLibro(libro $libro): static
    {
        if (!$this->libros->contains($libro)) {
            $this->libros->add($libro);
            $libro->setSocio($this);
        }

        return $this;
    }

    public function removeLibro(libro $libro): static
    {
        if ($this->libros->removeElement($libro)) {
            // set the owning side to null (unless already changed)
            if ($libro->getSocio() === $this) {
                $libro->setSocio(null);
            }
        }

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function isEsAdministrador(): ?bool
    {
        return $this->esAdministrador;
    }

    public function setEsAdministrador(bool $esAdministrador): static
    {
        $this->esAdministrador = $esAdministrador;

        return $this;
    }

    public function getRoles() : array
    {
        $roles = [];
        $roles[] = 'ROLE_USER';

        if ($this->isEsDocente()){
            $roles[] = 'ROLE_DOCENTE';
        }

        if ($this->isEsAdministrador()){
            $roles[] = 'ROLE_ADMIN';
        }

        return $roles;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {

    }

    public function getUsername()
    {
        return (string) $this->email;
    }

    public function getUserIdentifier()
    {
        return (string) $this->email;
    }

}
