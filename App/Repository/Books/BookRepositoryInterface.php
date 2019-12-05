<?php


namespace App\Repository\Books;


use App\Data\BookDTO;
use Generator;

interface BookRepositoryInterface
{
    public function insert(BookDTO $bookDTO) : bool;
    public function update(BookDTO $bookDTO, int $id) : bool;
    public function remove(int $id) : bool;
    public function addToCollection(int $bookId, int $userId): bool;
    public function checkBookExistInCollection(int $bookId, int $userId) : Generator;

    /**
     * @return Generator|BookDTO[]
     */
    public function findAll() : Generator;
    public function findOneById(int $id) : ?BookDTO;

    /**
     * @param int $id
     * @return Generator|BookDTO[]
     */
    public function findAddedBooks(int $id): \Generator;
    public function removeAddedBook(int $bookId): bool;
}