<?php

namespace App\Repository;

use App\Data\UserDTO;
use Core\DataBinderInterface;
use Database\DatabaseInterface;

class UserRepository extends DatabaseAbstract implements UserRepositoryInterface
{
    public function __construct(DatabaseInterface $database, DataBinderInterface $dataBinder)
    {
        parent::__construct($database, $dataBinder);
    }

    /**
     * @param UserDTO $userDTO
     * @return bool
     */
    public function insert(UserDTO $userDTO): bool
    {
        $this->db->query(
            'INSERT INTO xs_library.users(first_name, last_name, email, password)
                  VALUES(?,?,?,?)
             '
        )->execute([
            $userDTO->getFirstName(),
            $userDTO->getLastName(),
            $userDTO->getEmail(),
            $userDTO->getPassword()
        ]);

        return true;
    }

    /**
     * @param int $id
     * @param UserDTO $userDTO
     * @return bool
     */
    public function update(int $id, UserDTO $userDTO): bool
    {
        $this->db->query(
            '
                UPDATE xs_library.users
                SET 
                  first_name = ?,
                  last_name = ?,
                  email = ?,
                  password = ?
                WHERE id = ? 
            '
        )->execute([
            $userDTO->getFirstName(),
            $userDTO->getLastName(),
            $userDTO->getEmail(),
            $userDTO->getPassword(),
            $id
        ]);

        return true;
    }

    /**
     * @param UserDTO $userDTO
     * @return bool
     */
    public function approve(UserDTO $userDTO) : bool
    {
        $this->db->query(
            '
                UPDATE xs_library.users
                SET 
                  active = ?
                WHERE id = ?
            '
        )->execute([
            $userDTO->getActive(),
            $userDTO->getId()
        ]);

        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $this->db->query('DELETE FROM xs_library.users WHERE id = ?')
            ->execute([$id]);

        return true;
    }

    /**
     * @param string $email
     * @return UserDTO|null
     */
    public function findOneByEmail(string $email): ?UserDTO
    {
        return $this->db->query(
            'SELECT id, 
                    first_name AS firstName, 
                    last_name AS lastName, 
                    email,
                    password,
                    active,
                    is_admin AS isAdmin
                  FROM xs_library.users
                  WHERE email = ?
             '
        )->execute([$email])
            ->fetch(UserDTO::class)
            ->current();

    }

    /**
     * @param int $id
     * @return UserDTO|null
     */
    public function findOneById(int $id): ?UserDTO
    {
        return $this->db->query(
            'SELECT id, 
                    first_name AS firstName,
                    last_name AS lastName, 
                    email,
                    password,
                    active,
                    is_admin AS isAdmin
                  FROM xs_library.users
                  WHERE id = ?
             '
        )->execute([$id])
            ->fetch(UserDTO::class)
            ->current();
    }

    /**
     * @return \Generator|UserDTO[]
     */
    public function findAll(): \Generator
    {
        return $this->db->query(
            '
                  SELECT id, 
                      first_name AS firstName,
                      last_name AS lastName, 
                      email,
                      password,
                      active,
                      is_admin AS isAdmin
                  FROM xs_library.users
                  WHERE  active = 0

            '
        )->execute()
            ->fetch(UserDTO::class);
    }
}