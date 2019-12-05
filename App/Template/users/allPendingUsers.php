<?php /** @var \App\Data\UserDTO[] $data */ ?>
<?php
if ($data->valid() === false && $_SESSION['admin'] == 1){
    echo '<h1>No Pending users</h1>
          Go back to <a href="profile.php">your profile</a>';
}
else if($_SESSION['admin'] == 1) { ?>
    <h1>Pending activation users</h1>
<table border="1">
    <thead>
    <tr>
        <td>Id</td>
        <td>FirstName</td>
        <td>LastName</td>
        <td>Activate</td>
    </tr>
    </thead>
    <form method="post">
    <tbody>
        <?php foreach ($data as $userDTO): ?>
            <tr>
                <td><?= $userDTO->getId(); ?></td>
                <td><?= $userDTO->getFirstName(); ?></td>
                <td><?= $userDTO->getLastName(); ?></td>
                <td><input type="checkbox" name="<?= $userDTO->getId(); ?>"></td>
            </tr>
        <?php endforeach; ?>
        <input type="submit" name="approve" value="Approve"/>
    </tbody>
    </form>
</table>
<br />
Go back to <a href="profile.php">your profile</a>
<?php }
else {
    header('Location: profile.php');
}  ?>