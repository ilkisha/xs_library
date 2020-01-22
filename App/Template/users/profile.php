<?php /** @var \App\Data\UserDTO $data */?>
<h1>Hello, <?= $data->getFirstName() . ' ' . $data->getLastName()?></h1>
<?php
if($data->getIsAdmin() == 1){
    echo "<h3 style='color: red'>You're the admin!<h3>
          <a href=\"createBook.php\">Create book</a><br/>
          <a href=\"allPendingUsers.php\">All pending users</a><br/>";
} else {
    echo '<a href="myBooksCollections.php">My books</a><br/>';
}
?>
<a href="myProfile.php">Edit Profile</a><br/>
<a href="logout.php">Logout</a>

<br/>
<br/>

<a href="allBooks.php">All Books</a> <br/>
