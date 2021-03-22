<?php
include_once "./genfunc/globalstart.php";
set_time_limit(6000);
global $sesuser, $iuser, $ipass, $dhost, $ddbname, $dport, $dsocket, $ruser, $suser, $uuser;
$i=1;
while($i < 1000000000) {
$link = mysqli_connect($dhost, "Apacher", "apacher", $ddbname, $dport, $dsocket);
if (!$link) {
	echo "loh";
} else {
mysqli_set_charset($link, "utf8");
$sql = "INSERT INTO `simbiat`.`ed__transactions` (`sector`, `mainaccount`, `custref`, `ouref`, `acref`, `snflag`, `edtype`, `edno`, `eddatey`, `eddatem`, `eddated`, `edauthor`, `edreciever`, `uip`, `status`, `ponumber`, `PaytKind`, `amount`, `transkind`, `priority`, `pocondition`, `acceptterm`, `datey`, `datem`, `dated`, `DateCollectBanky`, `DateCollectBankm`, `DateCollectBankd`, `ReceiptDatey`, `ReceiptDatem`, `ReceiptDated`, `ChargeOffDatey`, `ChargeOffDatem`,";
$sql = $sql."`ChargeOffDated`,`remAccount`, `remINN`, `remKPP`, `remBIC`, `remCorrAcc`, `remname`, `benAccount`, `benINN`, `benKPP`, `benBIC`, `benCorrAcc`, `benname`, `DrawerStatus`, `CBC`, `OKTMO`, `TaxReason`, `TaxPeriod`, `TaxDocNumber`, `TaxPaytKind`, `taxcode`, `PP_TransContent`, `PP_TransKind`, `PaymentDetails`) VALUES ('ICG', '0700701026', '', '', '', 'NDV', 'ED103', '11042', '2014', '02', '11', '6577756000', '', '', 'C', '109', '', '144027', '02',";
$sql = $sql." '5', '2', '', '2014', '02', '11', '2014', '02', '11', '2014', '02', '11', '2014', '02', '11', '30302810400000000456', '6672244954', '', '046577756', '30101810800000000756', 'ООО ТМК-Премиум Сервис р/с 40702810304400000031 в ФИЛИАЛ МОСКОВСКИЙ ОАО СКБ-БАНК г Москва', '40702810390470470116', '7707280394', '', '044525202', '30101810300000000202', 'ООО Юнайтед Парсел Сервис (РУС)', 'P', '', '', '', '', '', '', '', '', '', 'Для зачислений на р/с №40702810500700701026 №ЮПС30Y7X5 оплата по сч. №5520/SD от 31.12.2013 за транспортно-экспедиционные услуги, в том числе НДС 219.70')";
mysqli_query($link, mb_convert_encoding($sql, "UTF-8","Windows-1251"));
mysqli_close($link);
}
$i++;
}
?>