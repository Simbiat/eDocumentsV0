<?php
include_once "./genfunc/globalstart.php";
set_time_limit(600);
if ($loggedin) {
	if (isset($_SESSION['usergroup'])) {
			if (strcasecmp($_SESSION['usergroup'], "ispclient") == 0 or strcasecmp($_SESSION['usergroup'], "isops") == 0 or strcasecmp($_SESSION['usergroup'], "iscclient") == 0) {
				if (isset($_SESSION['username'])) {
					$rights = json_decode(str_replace("for(;;);", "", decrypt(getrights($_SESSION['username']))), true);
					if (strcasecmp($_SESSION['usergroup'], "ispclient") == 0 or strcasecmp($_SESSION['usergroup'], "iscclient") == 0) {
						//rights check for future release to be done here
					}
					//query building should be done here in future (through separate file)
					$docs = docgrabber();
					require_once('./genfunc/tcpdf/tcpdf.php');
					$pdf= new TCPDF();
					$certificate = 'file://'.realpath("./genfunc/tcpdf.crt");
					$digsiginfo = array(
						'Name' => 'Citi test',
						'Location' => 'Test workstation',
						'Reason' => 'Testing signing',
						'ContactInfo' => 'http://89.179.242.234',
					);
					$pdf->SetAuthor('Citi test');
					$pdf->SetTitle('Test order');
					$pdf->SetMargins('1','10','1');
					$pdf->SetAutoPageBreak(true, 1);
					$pdf->SetPrintHeader(false);
					$pdf->SetPrintFooter(false);
					$pdf->SetFont('cour','',9);
					$pdf->SetTextColor(50,60,100);
					foreach ($docs as $doc) {
						$printdate = date("d.m.Y");
						$recieptdate = substr("0".$doc['ReceiptDated'], "-2").".".substr("0".$doc['ReceiptDatem'], "-2").".".$doc['ReceiptDatey'];
						$chargedate = substr("0".$doc['ChargeOffDated'], "-2").".".substr("0".$doc['ChargeOffDatem'], "-2").".".$doc['ChargeOffDatey'];
						//$sum = substr($doc['amount'], 0, "-2")."-".substr("0".substr($doc['amount'], "-2"), "-2");
						$sum = mt_rand()."-".substr("0".mt_rand(0, 99), "-2");
						$textsum = mb_convert_encoding(num2str(str_replace("-", ".", $sum)), "UTF-8","Windows-1251");
						$ponumber = $doc['ponumber'];
						$reminn = $doc['remINN'];
						$beninn = $doc['benINN'];
						$remkpp = $doc['remKPP'];
						$benkpp = $doc['benKPP'];
						$remname = $doc['remname'];
						$benname = $doc['benname'];
						$rembic = $doc['remBIC'];
						$benbic = $doc['benBIC'];
						$remcorracc = $doc['remCorrAcc'];
						$bencorracc = $doc['benCorrAcc'];
						$remacc = $doc['remAccount'];
						$benacc = $doc['benAccount'];
						$priority = $doc['priority'];
						$cbc = $doc['CBC'];
						$oktmo = $doc['OKTMO'];
						$taxreason = $doc['TaxReason'];
						$taxperiod = $doc['TaxPeriod'];
						$taxnumber = $doc['TaxDocNumber'];
						if ($doc['TaxDocDated'] AND $doc['TaxDocDatem'] AND $doc['TaxDocDatey']) {
							$taxdate = substr("0".$doc['TaxDocDated'], "-2").".".substr("0".$doc['TaxDocDatem'], "-2").".".$doc['TaxDocDatey'];
						} else {
							$taxdate = "";
						}
						$taxtype = $doc['TaxPaytKind'];
						$paydetails = $doc['PaymentDetails'];
						$pdf->AddPage('P', 'mm', 'A4', 'false', 'UTF-8', 'false', 'true');
						$pdf->SetDisplayMode('real','default');
						require('./genfunc/templates/incomingmow.php');
						$pdf->writeHTML($html, true, false, false, false, '');
					}
					//$pdf->setSignature($certificate, $certificate, 'tcpdfdemo', '', 2, $digsiginfo);
					$pdf->setprotection(array('modify', 'copy', 'annot-forms', 'fill-forms', 'extract', 'assemble', 'print-high'), '', null, '3');
					ob_start();
					$pdf->Output('example1.pdf','I');
				} else {
					header('Location: ../edocuments/index.php');
				}
			} else {
				header('Location: ../edocuments/index.php');
			}
	} else {
		header('Location: ../edocuments/index.php');
	}
} else {
	header('Location: ../edocuments/index.php');
}
?>