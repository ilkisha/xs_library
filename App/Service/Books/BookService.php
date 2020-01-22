<?php


namespace App\Service\Books;


use App\Data\BookDTO;
use App\Repository\Books\BookRepositoryInterface;
use App\Service\UserServiceInterface;

class BookService implements BookServiceInterface
{
    /**
     * @var BookRepositoryInterface
     */
    private $bookRepository;

    /**
     * @var UserServiceInterface
     */
    private $userService;

    public function __construct(BookRepositoryInterface $bookRepository,
                                UserServiceInterface $userService)
    {
        $this->bookRepository = $bookRepository;
        $this->userService = $userService;
    }

    /**
     * @param BookDTO $bookDTO
     * @return bool
     */
    public function add(BookDTO $bookDTO): bool
    {
        if(!$this->bookRepository->checkIsbnExist($bookDTO->getIsbn())->valid()) {
            return $this->bookRepository->insert($bookDTO);
        }

        return false;
    }

    /**
     * @param BookDTO $bookDTO
     * @param int $id
     * @return bool
     */
    public function edit(BookDTO $bookDTO, int $id): bool
    {
        return $this->bookRepository->update($bookDTO, $bookDTO->getId());
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {

        return $this->bookRepository->remove($id);
    }

    /**
     * @return \Generator|BookDTO[]
     */
    public function getAll(): \Generator
    {
        return $this->bookRepository->findAll();
    }

    /**
     * @param int $id
     * @return BookDTO
     */
    public function getOneById(int $id): ?BookDTO
    {
        return $this->bookRepository->findOneById($id);
    }

    /**
     * @return mixed
     */
    public function getAllByAuthorId()
    {
        $currentUser = $this->userService->currentUser();
        return $this->bookRepository->findAllByAuthorId($currentUser->getId());
    }

    /**
     * @param int $bookId
     * @param int $userId
     * @return bool
     */
    public function addToCollection(int $bookId, int $userId): bool
    {
        return $this->bookRepository->addToCollection($bookId, $userId);
    }

    public function checkBookExistInCollection(int $bookId, int $userId) : \Generator
    {
        return $this->bookRepository->checkBookExistInCollection($bookId, $userId);
    }

    /**
     * @param int $userId
     * @return \Generator
     */
    public function findAddedBooks(int $userId): \Generator
    {
        $currentUser = $this->userService->currentUser();
        return $this->bookRepository->findAddedBooks($currentUser->getId());
    }

    /**
     * @param int $bookId
     * @return bool
     */
    public function removeMyBook(int $bookId): bool
    {
        return $this->bookRepository->removeAddedBook($bookId);
    }
}