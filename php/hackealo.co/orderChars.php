<?php
$str = strtolower("AmCyjxoGaypIOJobiogCZJioCOMCBhbRjpBHSHfPFYDRKvePttNDghSVCrVAdZYmtSwJpOsvFwvkDxcIbClQxeAmevcfntWBVykbZHgTaZZqAhGPqgPJHYsYdnndbqBEdNHIUtRfbilcNPyzMPfWccrlHuBMZLvtjCdnTULngcquvLbMgvzEIcnebQNBcXBOusgPJmJ");
$duplicates = [];
$res = [];

for($i = strlen($str); $i--;) {
  if(!isset($duplicates[$str[$i]])) $duplicates[$str[$i]] = 1;
  else $duplicates[$str[$i]]++;
}

arsort($duplicates);
foreach($duplicates as $k => $v) {
  if(!isset($res[$v])) $res[$v] = [$k];
  else array_push($res[$v], $k);
}

$y = "";
foreach($res as $k => $v) {
  sort($v);
  foreach($v as $toPrint) {
    $y .= $toPrint;
//    echo $toPrint." amount: ".$k."<br />";
  }
}
echo $y;