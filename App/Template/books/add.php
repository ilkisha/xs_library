<?php /** @var \App\Data\ErrorDTO $errors */?>
<h1>Create Book</h1>

<a href="profile.php">My Profile</a><br/>
<?php if(count($errors) !== 0){
    echo '<h2 style="color: red">' . $errors[0]->getMessage() . '</h2>';
} ?>
<form method="post">
    Book Name:   <input type="text" name="name"/><br/>
    ISBN:        <input type="text" name="isbn"/><br/>
    Description: <textarea rows="5" name="description"></textarea><br/>
    Image URL:   <input type="text" name="image"/><br/>
    <input type="submit" value="Create" name="add"/>
</form>

