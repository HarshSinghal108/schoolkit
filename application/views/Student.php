
<html>

<head>

</head>

<body>

<table>

<th>ID</th>
<th>Name</th>
<th>Class</th>
<th>Father Name</th>
<th>Email</th>
<th>Mobile</th>
<?php 
for($i=0 ; $i<count($student); $i++)
{ 
?>
<?php  echo $key;?>
<td><?php echo $student[$i]['id'] ?> </td>
<td><?php echo $student[$i]['name'] ?></td>
<td><?php echo $student[$i]['class'] ?></td>
<td><?php echo $student[$i]['father_name'] ?></td>
<td><?php echo $student[$i]['email'] ?></td>
<td><?php echo $student[$i]['mobile'] ?></td>
</tr>
<?php
}
?>
</table>


</body>
</html>