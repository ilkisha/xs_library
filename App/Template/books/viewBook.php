<?php /** @var \App\Data\BookDTO $data['book']*/ ?>
<?php /** @var \App\Data\UserDTO $data['isAdmin']*/ ?>
<?php /** @var \App\Data\ErrorDTO $errors */ ?>

<h1>View Book</h1>

<h3><a href="all_books.php">Back</a><br/></h3>

<a href="profile.php">My Profile</a><br/>


<p><b>Name:</b> <?= $data['book']->getName(); ?> </p>
<p><b>ISBN:</b> <?= $data['book']->getIsbn(); ?> </p>
<p><b>Description:</b> <?= $data['book']->getDescription(); ?> </p>

<?php if($data['isAdmin'] == '0'): ?>
    <a href="addToCollection.php/?id=<?= $data['book']->getId(); ?>">Add to My collection</a>
<?php endif; ?>
<br/>

<img src="<?= $data['book']->getImage(); ?>" alt="None" width="200" height="300"/>



