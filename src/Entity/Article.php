<?php
namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File; // Add this use statement

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
#[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column]
private ?int $id = null;

#[ORM\Column(length: 255)]
private ?string $name = null;

#[ORM\Column(length: 255)]
private ?string $prix = null;

#[ORM\Column(length: 255)]
private ?string $description = null;

#[ORM\Column(type: Types::DATE_MUTABLE)]
private ?\DateTimeInterface $date = null;

#[ORM\Column(length: 255, nullable: true)]
private ?string $photo = null;

private ?File $photoFile = null; // This is for handling the file upload

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

public function getPrix(): ?string
{
return $this->prix;
}

public function setPrix(string $prix): static
{
$this->prix = $prix;

return $this;
}

public function getDescription(): ?string
{
return $this->description;
}

public function setDescription(string $description): static
{
$this->description = $description;

return $this;
}

public function getDate(): ?\DateTimeInterface
{
return $this->date;
}

public function setDate(\DateTimeInterface $date): static
{
$this->date = $date;

return $this;
}

public function getPhoto(): ?string
{
return $this->photo;
}

public function setPhoto(?string $photo): static
{
$this->photo = $photo;

return $this;
}

// Add getters and setters for the File object
public function getPhotoFile(): ?File
{
return $this->photoFile;
}

public function setPhotoFile(?File $photoFile = null): static
{
$this->photoFile = $photoFile;

// If a file is set, update the timestamp to trigger re-upload
if ($photoFile) {
$this->setPhoto(null);  // Clear the previous photo if a new file is set
}

return $this;
}
}
