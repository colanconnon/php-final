
<h1> Insert New User </h1>
<?php
    if (!empty($errors)) {
        echo '<h3> Errors </h3>';
        foreach ($errors as $err) {
            echo '<p>'.$err.'</p>';
        }
    }
?>
<form method="POST" action="/Controllers/UserController.php?route=insert">
    <input <?php echo 'value="'.$user->firstName.'"' ?>  type="text" name="firstName" placeholder="First Name" />
    <br />
    <br />
    <input <?php echo 'value="'.$user->lastName.'"' ?> type="text" name="lastName" placeholder="Last Name" />
    <br />
    <br />
    <input <?php echo 'value="'.$user->age.'"' ?> type="text" name="age" placeholder="age" />
    <br />
    <br />
    <input <?php echo 'value="'.$user->username.'"' ?> type="text" name="username" placeholder="username" />
    <br />
    <br />
    <input type="submit" value="Submit" />
</form>