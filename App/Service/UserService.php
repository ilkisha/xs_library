<?php

namespace App\Service;

use App\Data\UserDTO;
use App\Repository\UserRepositoryInterface;
use App\Service\Encryption\EncryptionServiceInterface;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var EncryptionServiceInterface
     */
    private $encryptionService;

    public function __construct(UserRepositoryInterface $userRepository,
            EncryptionServiceInterface $encryptionService)
    {
        $this->userRepository = $userRepository;
        $this->encryptionService = $encryptionService;
    }

    /**
     * @param UserDTO $userDTO
     * @param string $confirmPassword
     * @return bool
     * @throws \Exception
     */
    public function register(UserDTO $userDTO, string $confirmPassword): bool
    {
        if($userDTO->getPassword() !== $confirmPassword){
            throw new \Exception('Passwords mismatch!');
        }

        if(null !== $this->userRepository->findOneByEmail($userDTO->getEmail())){
            throw new \Exception('Email already exists!');
        }

        $this->encryptPassword($userDTO);
        return $this->userRepository->insert($userDTO);
    }

    /**
     * @param string $email
     * @param string $password
     * @return UserDTO|null
     */
    public function login(string $email, string $password): ?UserDTO
    {
        $userFromDB = $this->userRepository->findOneByEmail($email);

        if(null === $userFromDB){
            return null;
        }

        if(false === $this->encryptionService->verify($password, $userFromDB->getPassword())){
            return null;
        }

        return $userFromDB;
    }

    /**
     * @return UserDTO|null
     */
    public function currentUser(): ?UserDTO
    {
        if(!$_SESSION['id']){
            return null;
        }

        return $this->userRepository->findOneById((int)$_SESSION['id']);
    }

    /**
     * @return bool
     */
    public function isLogged(): bool
    {
        if(!$this->currentUser()){
            return false;
        }
        return true;
    }

    /**
     * @param UserDTO $userDTO
     * @return bool
     */
    public function edit(UserDTO $userDTO): bool
    {
        if(null === $this->userRepository->findOneByEmail($userDTO->getEmail())){
            return false;
        }

        $this->encryptPassword($userDTO);
        return $this->userRepository->update((int)$_SESSION['id'], $userDTO);
    }

    /**
     * @return \Generator|UserDTO[]
     */
    public function getAll(): \Generator
    {
       return $this->userRepository->findAll();
    }

    /**
     * @param UserDTO $userDTO
     */
    private function encryptPassword(UserDTO $userDTO): void
    {
        $plainPassword = $userDTO->getPassword();
        $passwordHash = $this->encryptionService->hash($plainPassword);
        $userDTO->setPassword($passwordHash);
    }

    /**
     * @param string $email
     * @return UserDTO|null
     */
    public function getEmail(string $email): ?UserDTO
    {
        return $this->userRepository->findOneByEmail($email);
    }

    /**
     * @param string $id
     * @return UserDTO|null
     */
    public function getUserById(string $id): ?UserDTO
    {
        return $this->userRepository->findOneById($id);
    }

    /**
     * @param UserDTO $userDTO
     * @return bool
     */
    public function approve(UserDTO $userDTO): bool
    {
        return $this->userRepository->approve($userDTO);
    }
}