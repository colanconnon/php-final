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
    foreach ($users as $user) {
        echo '<tr>';
        echo '<td>'.$user->firstName.'</td>';
        echo '<td>'.$user->username.'</td>';
        echo '<td>'.$user->age.'</td>';
        echo '<td>'.$user->lastName.'</td>';
        echo '<td> <a href="/Controllers/UserController.php?route=update&id='.$user->id.'"> Edit </a>';
        echo '<td> <a href="/Controllers/UserController.php?route=showOne&id='.$user->id.'"> View </a>';
        echo '<td> <a href="/Controllers/UserController.php?route=delete&id='.$user->id.'"> Delete </a>';
        echo '</tr>';
    }
?>
</table>
