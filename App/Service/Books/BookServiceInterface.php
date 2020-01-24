<?php


namespace App\Service\Books;


use App\Data\BookDTO;

interface BookServiceInterface
{
    public function add(BookDTO $bookDTO) : bool;
    public function edit(BookDTO $bookDTO, int $id) : bool;
    public function delete(int $id) : bool;
    public function addToCollection(int $bookId, int $userId): bool;
    public function checkBookExistInCollection(int $bookId, int $userId) : \Generator;
    public function checkUrlIdExistOrValid(int $urlId) : \Generator;

    /**
     * @return \Generator|BookDTO[]
     */
    public function getAll() : \Generator;
    public function getOneById(int $id) : ?BookDTO;
    public function getAllByAuthorId();
    public function findAddedBooks(int $userId): \Generator;
    public function removeMyBook(int $bookId): bool;
}