<?php /** @var \App\Data\BookDTO $data */ ?>
<h1>Edit Book</h1>

<a href="profile.php">My Profile</a><br/>

<form method="post">
    Book Name:   <input type="text" name="name" value="<?= $data->getName(); ?>"/><br/>
    ISBN:        <input type="text" name="isbn" value="<?= $data->getIsbn(); ?>"/><br/>
    Description: <textarea rows="5" name="description"><?= $data->getDescription(); ?></textarea><br/>
    Image URL:   <input type="text" name="image" value="<?= $data->getImage(); ?>"/><br/>
    <input type="submit" value="Edit" name="edit"/>
</form>
