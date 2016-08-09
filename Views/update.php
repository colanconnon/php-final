
<h1> Insert New User </h1>
<?php
    if(!empty($errors)) {
        print("<h3> Errors </h3>");
        foreach($errors as $err){
            print('<p>'. $err . '</p>');
        }
    }
?>
<form method="POST" action="/Controllers/UserController.php?route=update">
    <input <?php print("value=" . $user->id) ?>  type="number" readonly name="Id" placeholder="Id" />
    <br />
    <br />
    <input <?php print('value="' . $user->firstName . '"') ?>  type="text" name="firstName" placeholder="First Name" />
    <br />
    <br />
    <input <?php print('value="' . $user->lastName. '"') ?>  type="text" name="lastName" placeholder="Last Name" />
    <br />
    <br />
    <input <?php print('value="' . $user->age. '"') ?> type="number" name="age" placeholder="age" />
    <br />
    <br />
    <input <?php print('value="' . $user->username. '"') ?>  type="text" name="username" placeholder="username" />
    <br />
    <br />
    <input type="submit" value="Submit" />
</form>