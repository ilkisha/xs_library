<h2>Login Form</h2>

<?php /** @var array $errors  */ ?>
<?php /** @var \App\Data\UserDTO $data */ ?>
<?php
    if(count($errors) > 0){
        foreach ($errors as $error){
            /**
             * @var \App\Data\ErrorDTO $error
             */
            echo "<p style='color: red'>".$error->getMessage()."</p>";
        }
    }
?>

<form method="post">
    <label>
        Email: <input type="text" name="email"/> <br/>
    </label>
    <label>
        Password: <input type="password" name="password" value="" /> <br/>
    </label>
    <label>
        <input type="submit" name="login" value="Login"/>
    </label>
</form>

<a href="index.php">back</a>