<?php

namespace App\Mapper;

use App\Entity\User;
use App\DTO\User\UserUpdateDTO;

class UserMapper
{
    public static function toUserUpdateDTO(User $user): UserUpdateDTO
    {
        $dto = new UserUpdateDTO();
        $dto->setEmail($user->getEmail());

        return $dto;
    }

    public static function updateUserFromDTO(UserUpdateDTO $dto, User $user): User
    {
        $user->setEmail($dto->getEmail());

        return $user;
    }
}
