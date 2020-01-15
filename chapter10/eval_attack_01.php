<?php 

$string = 'こたんたにたちたわた、世界！';
eval("echo htmlspecialchars(str_replace(" . $_GET['keyword'].",'', ".$string."), ENT_QUTES, 'UTF-8');");
?>
