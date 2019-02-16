<?php
if ( isset($_GET['pdf']) && isset($_GET['ad_id']) && isset($_GET['stats']) &&
	 $_GET['stats'] >= 7 && $_GET['stats'] <= 90 && $_GET['pdf'] == substr(md5($_GET['ad_id'].'1'), 1, 11) ) {
	$ad_id = $_GET['ad_id'];
	if ( file_exists(dirname(__FILE__).'/PDF/reports/ad-'.$ad_id.'.txt') ) {
		require_once(dirname(__FILE__).'/PDF/fpdf.php');
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',12);
		$days = $_GET['stats'];
		$data = file_get_contents(dirname(__FILE__).'/PDF/reports/ad-'.$ad_id.'.txt', true);
		$pdf->SetFontSize(10);
		$pdf->Cell(190, 8, date('Y/m/d H:i:s'), 0, 1, "R");
		$pdf->SetFontSize(14);
		$pdf->Cell(190, 14, 'ID: '.$ad_id, 0, 0, "C");
		$pdf->SetFontSize(10);
		$pdf->Ln(10);
		$i = 0;
		$d = 0;
		$n = 0;
		$values = explode('|', $data);
		foreach($values as $columnValue) {
			$entry = explode(';', $columnValue);
			if ( $d - date('z', $entry[1]) > $days ) {
				break;
			}
			if ( $entry[0] != '' ) {
				if ( date('W', $entry[1]) != $i ) {
					$pdf->Ln(5);
					$pdf->Cell(190, 8, '- - - - - - - - - - - - - -', 0, 1, "C");
					$i = date('W', $entry[1]);
				}
				$k = 0;
				if ( date('z', $entry[1]) != $n ) {
					$pdf->Ln(5);
					$n = date('z', $entry[1]);
					$k = 1;
					$pdf->SetDrawColor(211,211,211);
					$pdf->SetFillColor(211,211,211);
				}
				if ( $k == 1 ) {
					$pdf->Cell(190, 10, date('Y/m/d', $entry[1]), 1, 1, "C", true);
				}
				if ( $entry[0] == 'view' ) {
					$pdf->Cell(40, 8, date('Y/m/d', $entry[1]), 1, 0, "C");
					$pdf->Cell(110, 8, $entry[2], 1, 0, "C");
					$pdf->Cell(40, 8, $entry[3], 1, 1, "C");
				} else {
					$pdf->Cell(40, 8, date('H:i:s', $entry[1]), 1, 0, "C");
					$pdf->Cell(110, 8, $entry[2], 1, 0, "C");
					$pdf->Cell(40, 8, $entry[3], 1, 1, "C");
				}
				if ( $d == 0 ) {
					$d = date('z', $entry[1]);
				}
			}
		}
		$pdf->Ln(20);
		$pdf->SetFont('Arial','',12);
		$pdf->Ln();
//		$pdf->Output();
		$pdf->Output('D', 'statistics-'.$ad_id.'.pdf');
	}
}

