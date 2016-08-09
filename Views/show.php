<br />

<a href="/Controllers/UserController.php/?route=insert"> Insert a new User </a>
<br />
<br />
<table>
  <tr>
    <td> First Name </td>
    <td> last Name </td>
    <td> age </td>
    <td> username </td>
    <td> </td>
    <td> </td>
    <td> </td>

  </tr>
  <?php
foreach($users as $user){
    print("<tr>");
    print("<td>". $user->firstName . "</td>");
    print("<td>". $user->username . "</td>");
    print("<td>". $user->age . "</td>");
    print("<td>". $user->lastName . "</td>");
    print('<td> <a href="/Controllers/UserController.php?route=update&id='.$user->id .'"> Edit </a>');
    print('<td> <a href="/Controllers/UserController.php?route=showOne&id='.$user->id .'"> View </a>');
    print('<td> <a href="/Controllers/UserController.php?route=delete&id='.$user->id .'"> Delete </a>');
    print("</tr>");
}
?>
</table>