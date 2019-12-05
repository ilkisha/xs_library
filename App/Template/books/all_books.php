<?php /** @var \App\Data\BookDTO[] $data['books'] */ ?>
<?php /** @var \App\Data\UserDTO $data['user'] */ ?>

<h1>All Books</h1>

<?php if($data['user']->getIsAdmin() == '1'): ?>
<a href="create_book.php">Create book</a><br/>
<?php else: ?>
<a href="my_booksCollections.php">My Books</a><br>
<?php endif; ?>
<a href="myProfile.php">Edit Profile</a><br/>
<a href="profile.php">My Profile</a><br/>
<a href="logout.php">Logout</a>
<br/> <br/>

<?php if($data['books']->valid()): ?>

<table border="1">
    <thead>
    <tr>
        <th>Name</th>
        <th>ISBN</th>
        <th>Description</th>
        <th>Image</th>
        <th>Details</th>
        <?php if($data['user']->getIsAdmin() == '1'): ?>
        <th>Edit</th>
        <th>Delete</th>
        <?php endif; ?>
    </tr>
    </thead>
    <form method="post">
        <tbody>
        <?php foreach ($data['books'] as $book): ?>
            <tr>
                <td><?= $book->getName(); ?></td>
                <td><?= $book->getIsbn(); ?></td>
                <td><?= $book->getDescription(); ?></td>
                <td><img src="<?= $book->getImage(); ?>"/></td>
                <td><a href="view_book.php?id=<?= $book->getId();?>">details</a></td>
                <?php if($data['user']->getIsAdmin() == '1'): ?>
                <td><a href="editBook.php?id=<?= $book->getId(); ?>">edit book</a></td>
                <td><a href="deleteBook.php?id=<?= $book->getId(); ?>">delete book</a></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </form>
</table>
<?php else: ?>
    <h1>No books available!</h1>
<?php endif; ?>


