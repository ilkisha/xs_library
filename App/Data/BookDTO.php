<?php


namespace App\Data;


class BookDTO
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $isbn;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $image;

    /**
     * @var UserDTO $user
     */
    private $user;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getIsbn() : string
    {
        return $this->isbn;
    }

    /**
     * @param string $isbn
     */
    public function setIsbn(string $isbn) : void
    {
        $this->isbn = $isbn;
    }

    /**
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getImage() : string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image) : void
    {
        $this->image = $image;
    }

    /**
     * @return UserDTO
     */
    public function getUser() : UserDTO
    {
        return $this->user;
    }

    /**
     * @param UserDTO $user
     */
    public function setUser(UserDTO $user) : void
    {
        $this->user = $user;
    }

}