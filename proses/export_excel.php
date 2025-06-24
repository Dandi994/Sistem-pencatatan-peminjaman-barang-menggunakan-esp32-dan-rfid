<?php
require '../vendor/autoload.php';
include 'koneksi.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$tgl_awal = $_GET['tgl_awal'] ?? null;
$tgl_akhir = $_GET['tgl_akhir'] ?? null;

$sql = "SELECT * FROM tb_peminjaman p 
        JOIN tb_barang b ON p.kode_barang = b.id_barang 
        JOIN tb_card c ON p.uid_peminjam = c.id";

if ($tgl_awal && $tgl_akhir) {
    $sql .= " WHERE DATE(p.tgl_peminjaman) BETWEEN '$tgl_awal' AND '$tgl_akhir'";
}

$query = mysqli_query($koneksi, $sql);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Buat header
$headers = [
    'No',
    'UID',
    'Kelas',
    'Kode Barang',
    'Nama Barang',
    'Semester',
    'Tgl Peminjaman',
    'Tgl Pengembalian',
    'Status'
];

$sheet->fromArray($headers, null, 'A1');

// Styling Header: warna kuning dan bold
$sheet->getStyle('A1:I1')->applyFromArray([
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFFF00'], // warna kuning
    ],
    'font' => [
        'bold' => true,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ]
    ]
]);

// Isi data dan beri border
$row = 2;
$no = 1;
while ($data = mysqli_fetch_assoc($query)) {
    $sheet->fromArray([
        $no++,
        $data['uid'],
        $data['kelas'],
        $data['kode_barang'],
        $data['nama_barang'],
        $data['semester'],
        $data['tgl_peminjaman'],
        $data['tgl_pengembalian'],
        $data['status']
    ], null, 'A' . $row);

    // Tambahkan border untuk setiap baris data
    $sheet->getStyle("A$row:I$row")->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
            ]
        ]
    ]);

    $row++;
}

// Auto-fit kolom A sampai I
foreach (range('A', 'I') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Export
$filename = "Riwayat_Peminjaman_" . date("YmdHis") . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
