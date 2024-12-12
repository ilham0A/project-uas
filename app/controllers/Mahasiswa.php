<?php

require_once '../app/vendor/autoload.php'; // Autoload composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Mahasiswa extends Controller
{
    public function index()
    {
        $data['judul'] = 'Daftar Mahasiswa';
        $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->view('templates/header', $data);
        $this->view('mahasiswa/index', $data);
        $this->view('templates/footer');
    }

    public function detail($id)
    {
        $data['judul'] = 'Daftar Mahasiswa';
        $data['mhs'] = $this->model('Mahasiswa_model')->getMahasiswaById($id);
        $this->view('templates/header', $data);
        $this->view('mahasiswa/detail', $data);
        $this->view('templates/footer');
    }

    public function tambah()
    {
        if ($this->model('Mahasiswa_model')->tambahDataMahasiswa($_POST) > 0) {
            Flasher::setFlash('berhasil', 'ditambahkan', 'success');
            header('location: ' . BASEURL . '/mahasiswa');
            exit;
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'danger');
            header('location: ' . BASEURL . '/mahasiswa');
            exit;
        }
    }

    public function hapus($id)
    {
        if ($this->model('Mahasiswa_model')->hapusDataMahasiswa($id) > 0) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
            header('location: ' . BASEURL . '/mahasiswa');
            exit;
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'danger');
            header('location: ' . BASEURL . '/mahasiswa');
            exit;
        }
    }

    public function getUbah()
    {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            echo json_encode(['error' => 'ID tidak ditemukan']);
            return;
        }

        $data = $this->model('Mahasiswa_model')->getMahasiswaById($id);
        echo json_encode($data);
    }

    public function ubah()
    {
        if ($this->model('Mahasiswa_model')->ubahDataMahasiswa($_POST) > 0) {
            Flasher::setFlash('berhasil', 'diubah', 'success');
            header('location: ' . BASEURL . '/mahasiswa');
            exit;
        } else {
            Flasher::setFlash('gagal', 'diubah', 'danger');
            header('location: ' . BASEURL . '/mahasiswa');
            exit;
        }
    }

    public function exportPDF()
    {
        require_once '../app/libraries/fpdf/fpdf.php';

        $dataMahasiswa = $this->model('Mahasiswa_model')->getAllMahasiswa();

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(200, 10, 'DATA MAHASISWA', 0, 0, 'C');

        $pdf->SetFillColor(169, 169, 169);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Nama', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'NIM', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Email', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Jurusan', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(0, 0, 0);
        $no = 1;
        foreach ($dataMahasiswa as $mhs) {
            $pdf->Cell(10, 10, $no++, 1, 0, 'C');
            $pdf->Cell(40, 10, $mhs['nama'], 1);
            $pdf->Cell(30, 10, $mhs['nim'], 1);
            $pdf->Cell(50, 10, $mhs['email'], 1);
            $pdf->Cell(50, 10, $mhs['jurusan'], 1);
            $pdf->Ln();
        }

        $pdf->Output('D', 'data_mahasiswa.pdf');
    }

    public function exportExcel()
    {
        $dataMahasiswa = $this->model('Mahasiswa_model')->getAllMahasiswa();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menambahkan judul
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue('A1', 'Data Mahasiswa');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Menambahkan jarak antara judul dan tabel
        $headerRowStart = 3; // Header tabel akan dimulai dari baris ke-3
        $sheet->mergeCells("A2:E2"); // Baris ini dibiarkan kosong untuk jarak

        // Menambahkan header tabel
        $sheet->setCellValue('A' . $headerRowStart, 'No');
        $sheet->setCellValue('B' . $headerRowStart, 'Nama');
        $sheet->setCellValue('C' . $headerRowStart, 'NIM');
        $sheet->setCellValue('D' . $headerRowStart, 'Email');
        $sheet->setCellValue('E' . $headerRowStart, 'Jurusan');

        // Styling header tabel
        $headerStyleArray = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D3D3D3'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A' . $headerRowStart . ':E' . $headerRowStart)->applyFromArray($headerStyleArray);

        // Menambahkan data
        $row = $headerRowStart + 1; // Baris data dimulai setelah header
        $no = 1;
        foreach ($dataMahasiswa as $mhs) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $mhs['nama']);
            $sheet->setCellValue('C' . $row, $mhs['nim']);
            $sheet->setCellValue('D' . $row, $mhs['email']);
            $sheet->setCellValue('E' . $row, $mhs['jurusan']);
            $row++;
        }

        // Styling data tabel
        $dataStyleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A' . ($headerRowStart + 1) . ':E' . ($row - 1))->applyFromArray($dataStyleArray);

        // Menyimpan file Excel
        $filename = 'data_mahasiswa.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }



    public function printPageContent()
    {
        // Ambil data mahasiswa dari model
        $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();

        // Kembalikan tabel data mahasiswa tanpa header/footer
        header('Content-Type: text/html; charset=utf-8');
        $this->view('mahasiswa/print', $data);
    }
}
