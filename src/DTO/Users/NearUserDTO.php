<?php

namespace App\DTO\Users;

use Doctrine\Common\Collections\Collection;
use LongitudeOne\Spatial\PHP\Types\SpatialInterface;
use Symfony\Component\Serializer\Attribute\Groups;

class NearUserDTO {
    #[Groups(["user.listing"])]
    public int $id;

    #[Groups(["user.listing"])]
    public string $firstname;

    #[Groups(["user.listing"])]
    public string $lastname;

    #[Groups(["user.listing"])]
    public ?String $avatar;

    #[Groups(["user.listing"])]
    public string $description;

    #[Groups(["user.listing"])]
    public Collection $subCategories;

    #[Groups(["user.listing"])]
    public ?int $distance;

    #[Groups(["user.listing"])]
    public SpatialInterface $coordonne;

    #[Groups(["user.listing"])]
    public int $level; 
}