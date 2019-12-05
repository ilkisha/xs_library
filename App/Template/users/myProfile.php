<?php /** @var \App\Data\UserDTO $data */ ?>
<?php /** @var array $errors */ ?>

<h2>Your Profile</h2>

<?php
if(count($errors) > 0){
    foreach ($errors as $error){
        /**
         * @var \App\Data\ErrorDTO $error
         */
        echo "<p style='color: red'>".$error->getMessage(). '</p>';
    }
}
?>
<form method="post">
    <label>
        Email: <input type="text" name="email" value="<?= $data->getEmail(); ?>"  /><br/>
    </label>
    <label>
        Password: <input type="password" name="password"/><br/>
    </label>
    <label>
        Confirm Password: <input type="password" name="confirm_password"/><br/>
    </label>
    <label>
        First Name: <input type="text" name="first_name" value="<?= $data->getFirstName(); ?>"  /><br/>
    </label>
    <label>
        Last Name: <input type="text" name="last_name" value="<?= $data->getLastName(); ?>"  /><br/>
    </label>

    <input type="submit" name="edit" value="Edit"/> <br/>
</form>

You can <a href="logout.php">logout</a>