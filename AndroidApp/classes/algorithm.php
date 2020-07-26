<?php
require 'connect.php';
// ! get slots from database
$query1='select Time,Batch_id from batch';
$storeArray1 = mysqli_query($connection,$query1);
$slots= array( );

class Timebatch{
  public $Batch_id;
  public $Time;
}
while ($row = mysqli_fetch_assoc($storeArray1)) {
  $obj = new Timebatch();
  $obj->Batch_id=$row['Batch_id'];
  $obj->Time=$row['Time'];
  array_push($slots,$obj);
  

}


foreach($slots as $obj) {
    $obj->Time=(int)substr($obj->Time,0,2);

}


var_dump($slots);

// ! total number of slots

$no_of_slots =count($slots);

// ! Hardcode
$query='select Teacher_id from teacher';
$result = mysqli_query($connection,$query);

$storeArray = Array();
while ($row = mysqli_fetch_assoc($result)) {
    $storeArray[] =  $row['Teacher_id'];  

}

$final=array();
foreach($storeArray as $result) {
    array_push($final,$result);
}
$no_of_teachers=count($final);
echo '<br>'.$no_of_teachers;

// $no_of_teachers = 4;//temporary initialized with $no_of_slots

$no_of_slots_alloted_to_teacher = array_fill(0, $no_of_teachers ,0);
// print_r($no_of_slots_alloted_to_teacher);
// ! hashmap of teacher id and arraylist of slots as values
//! assigning teacher atleast one slot
$teacher_slot_hashmap = array();
for($i = 0 ;$i<$no_of_teachers;$i++){
  $teacher_slot_hashmap[$i] = array($slots[$i]);
  $no_of_slots_alloted_to_teacher[$i]+=1;
}

// print_r($teacher_slot_hashmap);
for($i=$no_of_teachers;$i<$no_of_slots;$i++){
  for($j=0;$j<$no_of_teachers;$j++){
    if($no_of_slots_alloted_to_teacher[$j]<5){
        echo"<br>";
        // ! no same slot, no consecutive slot, 8hrs max difference between 1st and last slot
        $slot_alloted=array();
        // $teacher_slot_hashmap[$j] is an array of objects of TimeBatch
        foreach ($teacher_slot_hashmap[$j] as $result1) {
          // echo ''. $result1->Batch_id . ' ' . $result1->Time . "<br>";
          array_push($slot_alloted,$result1->Time);

}
        if(!in_array($slots[$i]->Time,$slot_alloted) && !in_array($slots[$i]->Time+1,$slot_alloted) &&! in_array($slots[$i]->Time-1,$slot_alloted) && abs((min($slot_alloted)-$slots[$i])->Time)<9){
            array_push($teacher_slot_hashmap[$j],$slots[$i]);
            $no_of_slots_alloted_to_teacher[$j]+=1;
            break;
        }
    
        echo"<br>";
    }
  }

}
echo"<br><br><br><br>";

for($i=0;$i<$no_of_teachers;$i++){
  // var_dump($teacher_slot_hashmap[$i]);
  $len=count($teacher_slot_hashmap[$i]);
  for($k=0;$k<$len;$k++){
      $Batch_id=$teacher_slot_hashmap[$i][$k]->Batch_id;
      $Teacher_id=$final[$i];
      echo"<br><br><br><br>";
      $query="INSERT INTO timetable (Teacher_id, Batch_id)
      VALUES ($Teacher_id,$Batch_id)";
      $result = mysqli_query($connection,$query);
      echo "done";
    }
}

?>