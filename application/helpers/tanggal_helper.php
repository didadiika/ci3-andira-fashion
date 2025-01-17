<?php
function tgl_db($tgl)
{
	list($thn,$bln,$tgl) = explode("-",$tgl);
	$hasil = $tgl."-".$bln."-".$thn;
	return $hasil;
}
function tgl_pecah($tgl){
	list($tgl,$bln,$thn) = explode("-",$tgl);
	$hasil = $thn."-".$bln."-".$tgl;
	return $hasil;
}
function tgl_pecah_miring($tgl){
	list($tgl,$bln,$thn) = explode("/",$tgl);
	$hasil = $thn."-".$bln."-".$tgl;
	return $hasil;
}
function tgl_indo($tgl)
{
	if(!empty($tgl)){
	list($th,$bl,$tg)=explode("-",$tgl);
	switch($bl)
	{
		case"01":
		$bl="Januari";
		break;
		case"02":
		$bl="Februari";
		break;
		case"03":
		$bl="Maret";
		break;
		case"04":
		$bl="April";
		break;
		case"05":
		$bl="Mei";
		break;
		case"06":
		$bl="Juni";
		break;
		case"07":
		$bl="Juli";
		break;
		case"08":
		$bl="Agustus";
		break;
		case"09":
		$bl="September";
		break;
		case"10":
		$bl="Oktober";
		break;
		case"11":
		$bl="November";
		break;
		case"12":
		$bl="Desember";
		break;	
	}
	$hasil = $tg." ".$bl." ".$th;
	}
	return $hasil;
}
function tgl_indo_time($tgl)
{
	list($tgl,$waktu)=explode(" ",$tgl);
	list($th,$bl,$tg)=explode("-",$tgl);
	switch($bl)
	{
		case"01":
		$bl="Januari";
		break;
		case"02":
		$bl="Februari";
		break;
		case"03":
		$bl="Maret";
		break;
		case"04":
		$bl="April";
		break;
		case"05":
		$bl="Mei";
		break;
		case"06":
		$bl="Juni";
		break;
		case"07":
		$bl="Juli";
		break;
		case"08":
		$bl="Agustus";
		break;
		case"09":
		$bl="September";
		break;
		case"10":
		$bl="Oktober";
		break;
		case"11":
		$bl="November";
		break;
		case"12":
		$bl="Desember";
		break;	
	}
	$hasil = $tg." ".$bl." ".$th." ".$waktu;	
	return $hasil;
}

function tgl_indo_time_baru($tgl)
{
	list($tgl,$waktu)=explode(" ",$tgl);
	list($th,$bl,$tg)=explode("-",$tgl);
	$hasil = $tg."-".$bl."-".$th;	
	return $hasil;
}

function tglPecah($tanggal)
{
	list($tggl,$jam) = explode(" ",$tanggal);
	list($thn,$bln,$tgl) = explode("-",$tggl);
	$hasil = $tgl."-".$bln."-".$thn;
	return $hasil;
}

function tglEdit($tgl,$bln,$thn)
{
if($bln=="01" || $bln=="03" || $bln=="05" || $bln=="07" || $bln=="08" || $bln=="10" || $bln=="12")
{$akhir="31";}
else if($bln=="04" || $bln=="06" || $bln=="09" || $bln=="11")
{$akhir="30";}
else if(($bln=="02") && ($thn%400=="0" || ($thn%400!="0" && $thn%100!="0" && $thn%4=="0") ))
{$akhir="29";}
else if(($bln=="02") && (($thn%400!="0" && $thn%100=="0") || ($thn%400!="0" && $thn%100!="0" && $thn%4!="0") ))
{$akhir="28";}
	for($t=1; $t<=$akhir; $t++)
	{
		if($t==$tgl)
		{
			echo"<option value='$t' selected='$tgl'>$t</option>";
		}
		else
		{
			echo"<option value='$t'>$t</option>";			
		}

	}
}

function blnEdit($bln)
{
	$nama_bulan = array(01=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	for($b=01; $b<=12; $b++)
	{
		if($b==$bln)
		{
			echo"<option value='$b' selected='$bln'>$nama_bulan[$b]</option>";
		}
		else
		{
			echo"<option value='$b'>$nama_bulan[$b]</option>";
		}
	}
}
function thnEdit($awal,$akhir,$thn)
{
	for($t=$awal; $t<=$akhir; $t++)
	{
		if($t==$thn)
		{
			echo"<option value='$t' selected='$thn'>$t</option>";
		}
		else
		{
		echo"<option value='$t'>$t</option>";			
		}

	}
}

function convertTanggal($tgl)
{
	list($b,$t,$th) = explode("/",$tgl);	
	
	$hasil = $th."-".$b."-".$t;
	
	return $hasil;
}

function tglRange($tglmulai,$tglselesai)
{
	list($thn,$bln,$tgl) = explode("-",$tglmulai);
	$tmulai = $bln."/".$tgl."/".$thn;
	
	list($thn,$bln,$tgl) = explode("-",$tglselesai);
	$tselesai = $bln."/".$tgl."/".$thn;

	$hasil = $tmulai." - ".$tselesai;
	
	return $hasil;
}
?>