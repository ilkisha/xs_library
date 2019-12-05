<h2>Register Form</h2>

<?php /** @var array $errors  */ ?>

<?php
if(count($errors) > 0){
    foreach ($errors as $error){
        /**
         * @var \App\Data\ErrorDTO $error
         */
        echo "<p style='color: red'>".$error. '</p>';
    }
}
?>
<form method="post">
    <label>
        First Name: <input type="text" name="first_name"/><br />
    </label>
    <label>
        Last Name: <input type="text" name="last_name"/><br />
    </label>
    <label>
        Email: <input type="text" name="email"/> <br />
    </label>
    <label>
        Password: <input type="password" name="password"/> <br />
    </label>
    <label>
        Confirm Password: <input type="password" name="confirm_password"/> <br />
    </label>
    <input type="submit" name="register" value="Register"/> <br />
</form>

<a href="index.php">back</a>