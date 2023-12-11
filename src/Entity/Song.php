<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Odm\Filter\RangeFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\SongRepository;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Get;

use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;


#[ORM\Entity(repositoryClass: SongRepository::class)]
#[ApiResource(
    uriTemplate: 'artists/{artists_id}/album/{album_id}/songs',
    uriVariables: [
        
        'artists_id' => new Link(fromClass: Artist::class, toProperty: 'artist'),
        'album_id' => new Link(fromClass: Album::class, toProperty:'album'),

    ],
    operations: [new GetCollection(), new Post()]
    )]
    #[ApiResource(
        uriTemplate: 'artists/{artists_id}/album/{album_id}/songs/{id}',
        uriVariables: [
            
            'artists_id' => new Link(fromClass: Artist::class, toProperty: 'artist'),
            'album_id' => new Link(fromClass: Album::class, toProperty:'album'),
            'id' => new Link(fromClass: Song::class)
    
        ],
        operations: [new GetCollection(), new Post()]
        )]

#[ApiFilter(RangeFilter::class, properties: ['length'])]       
class Song
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $length = null;

    #[ORM\ManyToOne(inversedBy: 'songs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Album $album = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(int $length): static
    {
        $this->length = $length;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): static
    {
        $this->album = $album;

        return $this;
    }
}
