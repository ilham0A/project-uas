<?php
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
        // Kirim data ke model untuk disimpan
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
        // Kirim data ke model untuk disimpan
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

    // public function getUbah()
    // {
    //     echo json_encode($this->model('Mahasiswa_model')->getMahasiswaById($_POST['id']));
    // }

    public function getUbah()
    {
        // Pastikan data 'id' diterima
        $id = $_POST['id'] ?? null;

        if (!$id) {
            echo json_encode(['error' => 'ID tidak ditemukan']);
            return;
        }

        // Ambil data mahasiswa berdasarkan ID
        $data = $this->model('Mahasiswa_model')->getMahasiswaById($id);

        // Kembalikan data dalam format JSON
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
        // Import library FPDF
        require_once '../app/libraries/fpdf/fpdf.php';

        // Ambil data mahasiswa dari model
        $dataMahasiswa = $this->model('Mahasiswa_model')->getAllMahasiswa();

        // Inisialisasi FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        // Header tabel
        $pdf->SetFillColor(169, 169, 169); // Warna background abu-abu tua
        $pdf->SetTextColor(255, 255, 255); // Warna teks putih
        $pdf->Cell(10, 10, 'ID', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Nama', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'NIM', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Email', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Jurusan', 1, 1, 'C', true);

        // Isi tabel
        $pdf->SetFont('Arial', '', 12); // Kembali ke font normal
        $pdf->SetTextColor(0, 0, 0); // Warna teks hitam
        foreach ($dataMahasiswa as $mhs) {
            $pdf->Cell(10, 10, $mhs['id'], 1, 0, 'C'); // Kolom ID, rata tengah
            $pdf->Cell(40, 10, $mhs['nama'], 1);       // Kolom Nama
            $pdf->Cell(30, 10, $mhs['nim'], 1);        // Kolom NIM
            $pdf->Cell(50, 10, $mhs['email'], 1);      // Kolom Email
            $pdf->Cell(50, 10, $mhs['jurusan'], 1);    // Kolom Jurusan
            $pdf->Ln();
        }
        // Output file PDF ke browser
        $pdf->Output('D', 'data_mahasiswa.pdf'); // File akan diunduh dengan nama 'data_mahasiswa.pdf'
    }
}
