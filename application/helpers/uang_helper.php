<?php

function uangRp($angka)
{
	$hasil = "Rp ".number_format($angka,0,',','.');
	
	return $hasil;
}
function uang($angka)
{
	
	$hasil = number_format($angka,0,',','.');
	if($angka < 0)
	{
		$hasil = "(".number_format(abs($angka),0,',','.').")";
	}
	
	return $hasil;
}

function uangPecah($uang){

$hasil = str_replace(".","",$uang);

return $hasil;	
}

function uangRpBiasa($uangRp)
{
	list($matauang,$uang) = explode(" ",$uangRp);
	
	$hasil = str_replace(".","",$uang);
	
	return $hasil;
}
?>