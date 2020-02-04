<?php

$this->excel->setActiveSheetIndex(0);
$this->excel->getActiveSheet()->setTitle('Laporan Peminjaman');

$border_set = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => '000000'),
			),
		'inline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => '000000'),
			),
		),
	);

$columnHead = array('No.', 'Nama Barang/Alat', 'Jumlah', 'Tanggal Peminjaman','Tanggal Kembali','Peminjaman','Tanda Tangan','Keterangan');
$this->excel->getActiveSheet()
->fromArray(
	$columnHead,  
	NULL,       
	'A5'      
	);   

$this->excel->getActiveSheet()->getStyle('A1:H5')->applyFromArray($border_set);

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('assets/img/logo/logo-horizontal-white.png');
$objDrawing->setCoordinates('B1');
$objDrawing->setHeight(75);
$objDrawing->setOffsetX(30);
$objDrawing->setOffsetY(15);
$objDrawing->setWorksheet($this->excel->getActiveSheet()); 

$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

$this->excel->getActiveSheet()->getRowDimension('5')->setRowHeight(40);
$this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
$this->excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$this->excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
$this->excel->getActiveSheet()->getRowDimension('4')->setRowHeight(20);

$this->excel->getActiveSheet()->getStyle('A1:H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A1:H5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$this->excel->getActiveSheet()->mergeCells('A1:B4');

$this->excel->getActiveSheet()->setCellValue('C1', "BIDANG PROGRAM DAN FASILITAS\nPUSTAJFA LAPAN");
$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setWrapText(true);
$this->excel->getActiveSheet()->mergeCells('C1:F2');

$this->excel->getActiveSheet()->setCellValue('G1', 'No. Dokumen');
$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(12);

$this->excel->getActiveSheet()->setCellValue('G2', 'Berlaku Sejak');
$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);

$this->excel->getActiveSheet()->setCellValue('H1', $data[0]->noDokPeminjaman);
$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(12);

$this->excel->getActiveSheet()->setCellValue('H2', showDate(strtotime($data[0]->tanggalPinjam)));
$this->excel->getActiveSheet()->getStyle('H2')->getFont()->setSize(12);

$this->excel->getActiveSheet()->setCellValue('C3', "FORMULIR\nPEMINJAMAN BARANG / ALAT");
$this->excel->getActiveSheet()->getStyle('C3')->getFont()->setSize(12);
$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
$this->excel->getActiveSheet()->mergeCells('C3:H4');

//CONTENT
$no = 0;
$cell = 5;
foreach ($data as $value) {
	$no++;
	$cell++;

	$kodeItem = "";
	$kondisiItem = array();
	$jml = 0;

	$items = $this->Model_report->getItemPinjam(array('a.idPeminjaman' => $value->idPeminjaman,'b.idBarang' => $value->idBarang));
	foreach ($items as $key) {
		$kodeItem .= "\n".$key->kodeItem;
		$jml += $key->jumlah;
		$kondisi = getField('pengembalian_pinjaman','kondisiItem',array('idPeminjaman' => $value->idPeminjaman,'idItem' => $key->idItem));
		if ($kondisi != '0') {
			array_push($kondisiItem, $kondisi);
		}
	}

	$this->excel->getActiveSheet()->setCellValue('A'.$cell, $no);
	$this->excel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	$this->excel->getActiveSheet()->setCellValue('B'.$cell, "".$value->namaBarang.$kodeItem);
	$this->excel->getActiveSheet()->getStyle('B'.$cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('B'.$cell)->getAlignment()->setWrapText(true);

	$this->excel->getActiveSheet()->setCellValue('C'.$cell, $jml);
	$this->excel->getActiveSheet()->getStyle('C'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('C'.$cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	$this->excel->getActiveSheet()->setCellValue('D'.$cell, showDate(strtotime($value->tanggalPinjam))."\n".'s/d'."\n".showDate(strtotime($value->batasPinjam)));
	$this->excel->getActiveSheet()->getStyle('D'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('D'.$cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('D'.$cell)->getAlignment()->setWrapText(true);

	$this->excel->getActiveSheet()->setCellValue('E'.$cell, $value->tanggalKembali != NULL ? showDate(strtotime($value->tanggalKembali)) : '-');
	$this->excel->getActiveSheet()->getStyle('E'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('E'.$cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	$this->excel->getActiveSheet()->setCellValue('F'.$cell, $value->nameUser);
	$this->excel->getActiveSheet()->getStyle('F'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('F'.$cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	$this->excel->getActiveSheet()->setCellValue('H'.$cell, implode("\n", $kondisiItem));	
	$this->excel->getActiveSheet()->getStyle('H'.$cell)->getAlignment()->setWrapText(true);
	$this->excel->getActiveSheet()->getStyle('H'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('H'.$cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	$this->excel->getActiveSheet()->getStyle('A'.$cell.':H'.$cell)->applyFromArray($border_set);

}

// FOOTER

$cell2 = $cell+2;
$cell3 = $cell+3;
$cell4 = $cell+10;

$this->excel->getActiveSheet()->setCellValue('G'.$cell2, "Jakarta, ".'       '.getBulan(date('m'))." ".date('Y'));
$this->excel->getActiveSheet()->getStyle('G'.$cell2.':H'.$cell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->mergeCells('G'.$cell2.':H'.$cell2);

$this->excel->getActiveSheet()->setCellValue('G'.$cell3, 'Kabid. Program dan Fasilitas');
$this->excel->getActiveSheet()->getStyle('G'.$cell3.':H'.$cell3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->mergeCells('G'.$cell3.':H'.$cell3);

$this->excel->getActiveSheet()->setCellValue('G'.$cell4, '(Syarif Budiman, S.Pj, M.Sc.)');
$this->excel->getActiveSheet()->getStyle('G'.$cell4.':H'.$cell4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->mergeCells('G'.$cell4.':H'.$cell4);

$filename = 'report_peminjaman_'.$value->kodePeminjaman.'.xls'; 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$filename.'"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
$objWriter->save('php://output');