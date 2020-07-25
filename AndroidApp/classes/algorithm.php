<?php
// ! get slots from database

// ! hardcode
$slots = array(1,2,3,4,5,6,7,8,9,9,10,7,6,5,4,3,2);

// print_r($slots);
echo"<br>".count($slots);
// ! total number of slots

$no_of_slots =count($slots);

// ! Hardcode
$no_of_teachers = 4;//temporary initialized with $no_of_slots

$no_of_slots_alloted_to_teacher = array_fill(0, $no_of_teachers , 0);
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
        if(!in_array($slots[$i],$teacher_slot_hashmap[$j]) && !in_array($slots[$i]+1,$teacher_slot_hashmap[$j])&&!in_array($slots[$i]-1,$teacher_slot_hashmap[$j]) && abs((min($teacher_slot_hashmap[$j])-$slots[$i]))<9){
            array_push($teacher_slot_hashmap[$j],$slots[$i]);
            $no_of_slots_alloted_to_teacher[$j]+=1;
            break;
        }
        echo"<br>";
    }
  }

}
for($i=0;$i<$no_of_teachers;$i++){
  var_dump($teacher_slot_hashmap[$i]);
  echo"<br><br>";
}
?>