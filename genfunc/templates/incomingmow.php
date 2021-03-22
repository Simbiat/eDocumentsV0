<?php
$html = "
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
<html>
<head>
	<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\" />
	<title></title>
	<style type=\"text/css\">
		.Date
		{
			text-align: center;
			border-width: 1px;
			border-color: #000000;
			border-top-style: solid;
			width: 120px;
		}
		.Date2
		{
			text-align: center;
			width: 120px;
		}
		.AllBorders
		{
			border: 1px solid #000000;
		}
		.WithoutTop
		{
			border-width: 1px;
			border-color: #000000;
			border-left-style: solid;
			border-right-style: solid;
			border-bottom-style: solid;
		}
		.BottomOnly
		{
			border-width: 1px;
			border-color: #000000;
			border-bottom-style: solid;
		}
		.BottomTop
		{
			border-width: 1px;
			border-color: #000000;
			border-bottom-style: solid;
			border-top-style: solid;
		}
		.TopOnly
		{
			border-width: 1px;
			border-color: #000000;
			border-top-style: solid;			
		}
		.RightOnly
		{
			border-width: 1px;
			border-color: #000000;
			border-right-style: solid;
		}
		.RightBottom
		{
			border-width: 1px;
			border-color: #000000;
			border-right-style: solid;
			border-bottom-style: solid;
		}
		.LeftRight
		{
			border-width: 1px;
			border-color: #000000;
			border-left-style: solid;
			border-right-style: solid;
		}
		.payment td
		{
			font-family: Courier New;
			font-size: 9pt;
			height: 20px;
		}
	</style>
</head>
<body>
	<table class=\"payment\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 680px; margin: 50px;\">
		<tr>
			<td>
				<table cellpadding=\"0\" cellspacing=\"0\">
					<tr>
						<td class=\"date2\" align=\"center\">
							{$recieptdate}
						</td>
						<td style=\"width: 120px\">
							&#160;
						</td>
						<td class=\"date2\" align=\"center\">
							{$chargedate}
						</td>
						<td style=\"width: 150px\">
							&#160;
						</td>
						<td rowspan=\"2\" align=\"right\" style=\"width: 100px\">
							<table style=\"width: 67px; border: solid 1px black\">
								<tr>
									<td align=\"center\" width=\"100%\">
										{Box1}
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class=\"date\" align=\"center\">
							Поступ. в банк плат.
						</td>
						<td style=\"width: 120px\">
							&#160;
						</td>
						<td class=\"date\" align=\"center\">
							Списано со сч. плат.
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<br />
			</td>
		</tr>
		<tr>
			<td>
				<table cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%\">
					<tr>
						<td rowspan=\"2\" width=\"250px\" style=\"font-size: 13px\">
							ПЛАТЕЖНОЕ ПОРУЧЕНИЕ N {$ponumber}
						</td>
						<td class=\"Date2\" align=\"center\">
							{$printdate}
						</td>
						<td rowspan=\"2\" style=\"width: 15px;\">
							&#160;
						</td>
						<td class=\"Date2\" align=\"center\">
							{Payment type}
						</td>
						<td style=\"width: 35px\">
							&#160;
						</td>
						<td rowspan=\"2\" align=\"right\">
							<table class=\"AllBorders\" style=\"width: 37px; height: 33px;\">
								<tr>
									<td align=\"center\" valign=\"middle\">
										{Box2}
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class=\"Date\">
							Дата
						</td>
						<td class=\"Date\">
							Вид платежа
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
					<tr>
						<td>
							&#160;
						</td>
					</tr>
					<tr>
						<td align=\"left\" valign=\"middle\" style=\"border-right-width:1px;border-right:solid; width: 80px; height: 45px\">
							<br><BR>Сумма<br />
							прописью
						</td>
						<td style=\"width:500px;vertical-align:middle;FONT-WEIGHT: normal; FONT-SIZE: 9.5pt; COLOR: #000000; FONT-FAMILY: Courier New\">
							<br><BR>&#160;{$textsum}
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table cellpadding=\"0\" cellspacing=\"0\">
					<tr>
						<td class=\"RightOnly\" style=\"height: 25px; width: 170px;\">
							ИНН {$reminn}
						</td>
						<td class=\"RightOnly\" style=\"width: 170px;\">
							&#160;КПП {$remkpp}
						</td>
						<td align=\"center\" style=\"border-top-width:1px;border-top-style:solid;border-right-width:1px;border-right-style:solid;width:50px\">
							<BR><BR><BR>Сумма
						</td>
						<td colspan=\"3\" style=\"border-top-width:1px;border-top-style:solid;width: 250px; font-family: Courier;\">
							&#160;{$sum}
						</td>
					</tr>
					<tr>
						<td colspan=\"2\" valign=\"top\" style=\"border-top-width:1px;border-top-style:solid;height: 24px; padding-top: 2px;\">
							{$remname}
						</td>
						<td style=\"border-left-width:1px;borer-left-style:solid;border-right-width:1px;border-right-style:solid;border-bottom-width:1px;border-bottom-style:solid;height: 24px; padding-top: 2px;\">
						</td>
						<td colspan=\"3\" style=\"border-left-width:1px;borer-left-style:solid;border-bottom-width:1px;border-bottom-style:solid;height: 24px; padding-top: 2px;\">
						</td>
					</tr>
					<tr>
						<td colspan=\"2\" valign=\"bottom\" style=\"border-bottom-width:1px;border-bottom-style:solid;height: 24px; padding-top: 2px;\">
							<br><BR><BR>Плательщик
						</td>
						<td align=\"center\" style=\"border-left-stlye:solid;border-left-width:1px;border-right-stlye:solid;border-right-width:1px;border-bottom-stlye:solid;border-bottom-width:1px;\">
							Cч.№
						</td>
						<td colspan=\"3\">
							&#160;{$remacc}
						</td>
					</tr>
					<tr>
						<td colspan=\"2\" style=\"height: 32px; padding-top: 2px;\" valign=\"top\">
							{Payer bank}
						</td>
						<td class=\"WithoutTop\" align=\"center\">
							БИК
						</td>
						<td colspan=\"3\">
							&#160;{$rembic}
						</td>
					</tr>
					<tr>
						<td colspan=\"2\" valign=\"bottom\" style=\"border-bottom-width:1px;border-bottom-style:solid;height: 24px; padding-top: 2px;\">
							<br><BR><BR>Банк плательщика
						</td>
						<td align=\"center\" style=\"border-left-stlye:solid;border-left-width:1px;border-right-stlye:solid;border-right-width:1px;border-bottom-stlye:solid;border-bottom-width:1px;\">
							Cч.№
						</td>
						<td colspan=\"3\" style=\"border-bottom-width:1px;border-bottom-style:solid;\">
							&#160;{$remcorracc}
						</td>
					</tr>
					<tr>
						<td colspan=\"2\" valign=\"top\" style=\"height: 32px; padding-top: 2px;\">
							{Recipient bank}
						</td>
						<td class=\"WithoutTop\" align=\"center\">
							БИК
						</td>
						<td colspan=\"3\">
							&#160;{$benbic}
						</td>
					</tr>
					<tr>
						<td colspan=\"2\" valign=\"bottom\" style=\"border-bottom-width:1px;border-bottom-style:solid;height: 24px; padding-top: 2px;\">
							<br><BR><BR>Банк получателя
						</td>
						<td align=\"center\" style=\"border-left-stlye:solid;border-left-width:1px;border-right-stlye:solid;border-right-width:1px;border-bottom-stlye:solid;border-bottom-width:1px;\">
							Сч.N
						</td>
						<td colspan=\"3\" style=\"border-bottom-width:1px;border-bottom-style:solid;\">
							&#160;{$bencorracc}
						</td>
					</tr>
					<tr>
						<td class=\"RightBottom\" style=\"height: 25px\">
							ИНН {$beninn}
						</td>
						<td class=\"BottomOnly\">
							&#160;КПП {$benkpp}
						</td>
						<td align=\"center\" valign=\"center\" style=\"border-top-width:1px;border-top-style:solid;border-right-width:1px;border-right-style:solid;width:50px;border-left-width:1px;border-left-style:solid;\">
							Cч.№
						</td>
						<td colspan=\"3\">
							&#160;{$benacc}
						</td>
					</tr>
					<tr>
						<td rowspan=\"3\" colspan=\"2\" valign=\"top\" style=\"border-top-width:1px;border-top-style:solid;height: 12px; padding-top: 2px;\">
							{$benname}
						</td>
						<td style=\"border-left-width:1px;borer-left-style:solid;border-right-width:1px;border-right-style:solid;border-bottom-width:1px;border-bottom-style:solid;height: 12px; padding-top: 2px;\">
						</td>
						<td colspan=\"3\" style=\"border-left-width:1px;borer-left-style:solid;border-bottom-width:1px;border-bottom-style:solid;height: 12px; padding-top: 2px;\">
						</td>
					</tr>
					<tr>
						<td class=\"AllBorders\">
							&#160;Вид&#160;оп.
						</td>
						<td class=\"TopOnly\" style=\"width: 60px;\">
							&#160;{c1}
						</td>
						<td class=\"AllBorders\">
							&#160;Срок&#160;плат
						</td>
						<td class=\"TopOnly\" style=\"width: 90px;\">
							&#160;{c2}
						</td>
					</tr>
					<tr>
						<td class=\"WithoutTop\">
							&#160;Наз.пл
						</td>
						<td>
							&#160;{c3}
						</td>
						<td class=\"WithoutTop\">
							&#160;Очер&#160;плат
						</td>
						<td>
							&#160;{$priority}
						</td>
					</tr>
					<tr>
						<td colspan=\"2\" valign=\"top\">
							Получатель
						</td>
						<td class=\"WithoutTop\">
							&#160;Код
						</td>
						<td>
							&#160;{c5}
						</td>
						<td class=\"WithoutTop\">
							&#160;Рез.поле
						</td>
						<td style=\"border-bottom-width:1px;border-bottom-style:solid;width: 42px;\">
							&#160;{c6}
						</td>
					</tr>
					<tr>
						<td class=\"RightOnly\" style=\"width: 155px;\">
							{$cbc}
						</td>
						<td class=\"RightOnly\" style=\"width: 85px;\">
							&#160;{$oktmo}
						</td>
						<td class=\"RightOnly\" style=\"width: 30px;\">
							&#160;{$taxreason}
						</td>
						<td class=\"RightOnly\" style=\"width: 70px;\">
							&#160;{$taxperiod}
						</td>
						<td class=\"RightOnly\" style=\"width: 115px;\">
							&#160;{$taxnumber}
						</td>
						<td class=\"RightOnly\" style=\"width: 70px;\">
							&#160;{$taxdate}
						</td>
						<td style=\"width: 50px;\">
							&#160;{$taxtype}
						</td>
					</tr>
					<tr>
						<td colspan=\"7\" style=\"border-top-width:1px;border-top-style:solid;height: 64px; word-break: break-all;\" valign=\"top\">
							{$paydetails}
						</td>
					</tr>
					<tr>
						<td colspan=\"7\" style=\"border-bottom-width:1px;border-bottom-style:solid;height: 32px; word-break: break-all;\" valign=\"bottom\">
							<BR><BR><BR>&#160;Назначение платежа
						</td>
					</tr>
					<tr>
						<td>
						</td>
						<td colspan=\"4\" align=\"left\" style=\"border-bottom-style:solid;border-bottom-width:1px;\">
							&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;Подписи<BR><BR>
						</td>
						<td align=\"center\" colspan=\"2\">
							Отметки&#160;банка
						</td>
					</tr>
					<tr>
						<td>
						</td>
						<td colspan=\"4\" align=\"left\" style=\"height:48px;border-bottom-style:solid;border-bottom-width:1px;\">
						</td>
						<td align=\"center\" colspan=\"2\">
						</td>
					</tr>
					<tr>
						<td align=\"center\">
							<BR><BR><BR>М.П.
						</td>
					</tr>
					<tr>
						<td colspan=\"5\">
						</td>
						<td colspan=\"2\" align=\"left\">
							<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin-left: 95px;\">
								<tr>
									<td>
										ЗАО КБ &quot;БАНК&quot;
									</td>
								</tr>
								<tr>
									<td>
										БИК {Stamp Bic}
									</td>
								</tr>
								<tr>
									<td>
										{Stamp Date}
									</td>
								</tr>
								<tr>
									<td>
										ПРОВЕДЕНО
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
";
?>