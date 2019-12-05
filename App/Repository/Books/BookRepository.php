<?php


namespace App\Repository\Books;


use App\Data\BookDTO;
use App\Repository\DatabaseAbstract;
use Generator;

class BookRepository extends DatabaseAbstract implements BookRepositoryInterface
{

    public function insert(BookDTO $bookDTO): bool
    {
        $this->db->query('
                    INSERT INTO xs_library.books(
                            name, 
                            isbn, 
                            description, 
                            image, 
                            user_id) 
                    VALUES (?, ?, ?, ?, ?)
        ')->execute([
            $bookDTO->getName(),
            $bookDTO->getIsbn(),
            $bookDTO->getDescription(),
            $bookDTO->getImage(),
            $bookDTO->getUser()->getId()
        ]);

        return true;
    }

    public function update(BookDTO $bookDTO, int $id): bool
    {
        $this->db->query('
                    UPDATE xs_library.books
                    SET
                            name = ?, 
                            isbn = ?, 
                            description = ?, 
                            image = ?
                    WHERE id = ?
        ')->execute([
            $bookDTO->getName(),
            $bookDTO->getIsbn(),
            $bookDTO->getDescription(),
            $bookDTO->getImage(),
            $id
        ]);

        return true;
    }

    public function remove(int $id): bool
    {
        $this->db->query('DELETE FROM xs_library.books WHERE id = ?')
            ->execute([$id]);
        $this->db->query('DELETE FROM xs_library.users_books WHERE book_id = ?')
            ->execute([$id]);

        return true;
    }

    /**
     * @return Generator|BookDTO[]
     */
    public function findAll(): Generator
    {
        return $this->db->query(
            '
                  SELECT id, 
                      name,
                      isbn, 
                      description,
                      image,
                      user_id AS user
                  FROM xs_library.books
            '
        )->execute()
            ->fetch(BookDTO::class);
    }

    public function findOneById(int $id): ?BookDTO
    {
        return $this->db->query(
            'SELECT id, 
                    name,
                    isbn, 
                    description,
                    image,
                    user_id AS user
                  FROM xs_library.books
                  WHERE id = ?
             '
        )->execute([$id])
            ->fetch(BookDTO::class)
            ->current();

    }

    public function addToCollection(int $bookId, int $userId): bool
    {
        $this->db->query(
            'INSERT INTO xs_library.users_books(
                        book_id,
                        user_id) 
                    VALUES (?, ?)'
        )->execute([$bookId, $userId]);

        return true;
    }

    public function checkBookExistInCollection(int $bookId, int $userId) : Generator
    {
       return $this->db->query(
            'SELECT 
                        users_books.book_id, 
                        users_books.user_id
                    FROM users_books
                    WHERE user_id = ? AND book_id = ?;
            '
        )->execute([$userId, $bookId])->fetchAssoc();
    }

    /**
     * @param int $id
     * @return Generator|BookDTO[]
     */
    public function findAddedBooks(int $userId): \Generator
    {
        return $this->db->query('
                SELECT user_id,
                       book_id
                  FROM xs_library.users_books
                  WHERE user_id = ?
        ')->execute([$userId])->fetchAssoc();
    }

    /**
     * @param int $bookId
     * @return bool
     */
    public function removeAddedBook(int $bookId) : bool
    {
        $this->db->query('DELETE FROM xs_library.users_books WHERE book_id = ?')
            ->execute([$bookId]);
        return true;
    }
}