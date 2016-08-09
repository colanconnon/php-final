<h1> Delete </h1>
<form method="POST" action="/Controllers/UserController.php?route=delete">
<input type="hidden" name="id" <?php print("value=" . $user->id) ?> />
<p> Delete Item <?php print("First Name: " .$user->firstName . " Last Name: " . $user->lastName); ?> </p>
<input type="submit" value="DELETE" />
</form>