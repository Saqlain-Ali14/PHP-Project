<?php
$id = intval($_GET['student']);

$con = mysqli_connect("localhost", "root", "", "Student_Management_System");
if (!$con) {
  echo "DataBase Not connected";
}

$sql="SELECT c.name,c.id FROM `student_enrollment` 
join course c on student_enrollment.cid=c.id
join student s on student_enrollment.sid=s.id
where s.id = '".$id."'";
$result = mysqli_query($con,$sql);
$res="";

while($row = mysqli_fetch_array($result)) {

  $res.= "<option value=".$row['id']." >" . $row['name'] . "</option>";
}
echo $res;
mysqli_close($con);
?>