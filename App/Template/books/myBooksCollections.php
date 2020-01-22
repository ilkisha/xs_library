<?php /** @var \App\Data\BookDTO[] $data */ ?>

<h1>My Books</h1>

<a href="allBooks.php">All Books</a><br/>
<a href="myProfile.php">Edit Profile</a><br/>
<a href="logout.php">Logout</a>

<br/> <br/>

<?php if($data): ?>
<table border="1">
    <thead>
    <tr>
        <th>Name</th>
        <th>ISBN</th>
        <th>Description</th>
        <th>Image</th>
        <th>View</th>
        <th>Remove</th>
    </tr>
    </thead>
    <form method="post">
        <tbody>
        <?php foreach ($data as $book): ?>
            <tr>
                <td><?= $book->getName()?></td>
                <td><?= $book->getIsbn(); ?></td>
                <td><?= $book->getDescription(); ?></td>
                <td><img src="<?= $book->getImage(); ?>"/></td>
                <td><a href="view_book.php?id=<?= $book->getId(); ?>">details</a></td>
                <td><a href="removeMyBook.php?id=<?= $book->getId(); ?>">remove</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </form>
</table>
<?php else: ?>
<h1>No books available! You can add books from here: <a href="allBooks.php">All books</a> </h1>
<?php endif; ?>
