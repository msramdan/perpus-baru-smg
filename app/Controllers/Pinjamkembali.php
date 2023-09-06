<?php

namespace App\Controllers;

use App\Models\pinjamkembaliModel;
use App\Models\logpinjamkembaliModel;
use App\Models\bukuModel;
use App\Models\anggotaModel;
use TCPDF;
use DateTime;

class PinjamKembali extends BaseController
{
    protected $pinjamkembaliModel;
    protected $logpinjamkembaliModel;
    protected $helpers = ['form'];
    protected $bukuModel;
    protected $anggotaModel;

    public function __construct()
    {
        $this->pinjamkembaliModel = new pinjamkembaliModel();
        $this->logpinjamkembaliModel = new logpinjamkembaliModel();
        $this->bukuModel = new bukuModel();
        $this->anggotaModel = new anggotaModel();
    }

    public function index()
    {
        $keywork = $this->request->getVar('keywork');
        if ($keywork) {
            $pinjamkembali = $this->pinjamkembaliModel->search($keywork);
        } else {
            $pinjamkembali = $this->pinjamkembaliModel;
        }
        // $pinjamkembaliModel = new pinjamkembaliModel();

        // return view('pinjamkembali/index', $data);
        $data = [
            'title' => 'Transaksi Buku',
            'pinjamkembali' => $this->pinjamkembaliModel->getPinjamKembali(),
            'buku' => $this->bukuModel->getBuku(),
            'anggota' => $this->anggotaModel->getAnggota()
        ];

        // menampilkan view
        return view('pinjamkembali/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Transaksi Buku',
            'buku' => $this->bukuModel->getBuku(),
            'anggota' => $this->anggotaModel->getAnggota()
        ];

        return view('pinjamkembali/create', $data);
    }

    public function getBukuByJudul($judul)
    {
        $buku = $this->bukuModel->where('judul', $judul)->first();
        return json_encode($buku);
    }

    public function getAnggotaByNama($nama)
    {
        $anggota = $this->anggotaModel->where('nama', $nama)->first();
        return json_encode($anggota);
    }


    public function peminjaman()
    {
        $isbn = $this->request->getVar('isbn');
        $buku = $this->bukuModel->where('isbn', $isbn)->first();
        $nomor = $this->request->getVar('nomor');
        $judul = $this->request->getVar('judul');
        $nama = $this->request->getVar('nama');
        $kelas = $this->request->getVar('kelas');
        $tgl_pinjam = $this->request->getPost('tgl_pinjam');
        $tgl_kembali = $this->request->getPost('tgl_kembali');
        if (!$buku) {
            return $this->response->setStatusCode(404)->setBody('Buku tidak ditemukan');
        }

        // Jika jumlah buku yang tersedia <= 0, tampilkan pesan error
        if ($buku['jumlah'] <= 0) {
            return $this->response->setStatusCode(400)->setBody('Buku sudah habis');
        }

        // Mengurangi jumlah buku yang tersedia
        $buku['jumlah']--;
        $this->bukuModel->save($buku);

        $this->pinjamkembaliModel->save([
            'isbn' => $isbn,
            'judul' => $judul,
            'nomor' => $nomor,
            'nama' => $nama,
            'kelas' => $kelas,
            'tgl_pinjam' => $tgl_pinjam,
            'tgl_kembali' => $tgl_kembali
        ]);

        $this->logpinjamkembaliModel->saveLog([
            'isbn' => $isbn,
            'judul' => $judul,
            'nomor' => $nomor,
            'nama' => $nama,
            'kelas' => $kelas,
            'tgl_pinjam' => $tgl_pinjam,
            'tgl_kembali' => $tgl_kembali,
            'status' => 'Peminjaman',
            'tgl_dibuat' => date('Y-m-d'),
        ]);


        session()->setFlashdata('pesan', 'Transaksi Buku Berhasil ditambahkan.');
        return redirect()->to('/pinjamkembali');
    }
    public function pengembalian($id)
    {
        // Ambil data peminjaman berdasarkan id
        $pinjaman = $this->pinjamkembaliModel->find($id);
        $this->logpinjamkembaliModel->saveLog([
            'isbn' => $pinjaman['isbn'],
            'judul' => $pinjaman['judul'],
            'nomor' => $pinjaman['nomor'],
            'nama' => $pinjaman['nama'],
            'kelas' => $pinjaman['kelas'],
            'tgl_pinjam' => $pinjaman['tgl_pinjam'],
            'tgl_kembali' => $pinjaman['tgl_kembali'],
            'tgl_dibuat' => date('Y-m-d'),
            'status' => 'Pengembalian',
        ]);
        if (!$pinjaman) {
            return $this->response->setStatusCode(404)->setBody('Peminjaman tidak ditemukan');
        }

        // Ambil data buku berdasarkan ISBN
        $isbn = $pinjaman['isbn'];
        $buku = $this->bukuModel->where('isbn', $isbn)->first();
        if (!$buku) {
            return $this->response->setStatusCode(404)->setBody('Buku tidak ditemukan');
        }

        // Tambah jumlah buku yang tersedia
        $buku['jumlah']++;
        $this->bukuModel->save($buku);
        // hapus buku
        $this->pinjamkembaliModel->delete($id);
        $session = session();
        $session->setFlashdata('pesan', 'Peminjaman berhasil dikembalikan.');

        return redirect()->to('/pinjamkembali');
    }

    public static function calculateDenda($tglKembali)
    {
        $tglKembali = new DateTime($tglKembali);
        $tglSekarang = new DateTime();

        // Menghitung selisih hari antara tanggal kembali dengan tanggal sekarang
        $selisih = $tglSekarang->diff($tglKembali)->days;

        // Jika tanggal kembali lebih besar dari atau sama dengan tanggal sekarang,
        // maka dendanya adalah 0
        if ($tglKembali >= $tglSekarang) {
            return "Rp 0";
        }

        $dendaPerHari = 500;
        $dendaTotal = $dendaPerHari * abs($selisih);

        return "Rp" . number_format($dendaTotal, 0, ',', '.');
    }

    public function cetakLaporan()
    {
        // Ambil data transaksi dari model
        $data['transaksi'] = $this->pinjamkembaliModel->getPinjamKembali();

        // Buat objek TCPDF
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

        // Set judul dokumen
        $pdf->SetTitle('Laporan Transaksi Peminjaman Buku');

        // Buat halaman
        $pdf->AddPage();

        // Tambahkan konten laporan di sini
        $content = '<h1>Laporan Transaksi Peminjaman Buku SMP Barunawati Semarang</h1>';
        $content .= '<p>Tanggal Cetak: ' . date('Y-m-d') . '</p>'; // Tambahkan tanggal cetak
        $content .= '<style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        /* Tambahkan margin di atas dan bawah tabel */
        table {
            margin-top: 10px;
            margin-bottom: 20px;
        }
        </style>';

        $content .= '<table>
        <tr>
            <th>No</th>
            <th>ISBN</th>
            <th>Judul</th>
            <th>ID Anggota</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Denda</th>
        </tr>';
        $i = 1;
        foreach ($data['transaksi'] as $transaksi) {
            $content .= '<tr>
                        <td>' . $i++ . '</td>
                        <td>' . $transaksi['isbn'] . '</td>
                        <td>' . $transaksi['judul'] . '</td>
                        <td>' . $transaksi['nomor'] . '</td>
                        <td>' . $transaksi['nama'] . '</td>
                        <td>' . $transaksi['kelas'] . '</td>
                        <td>' . $transaksi['tgl_pinjam'] . '</td>
                        <td>' . $transaksi['tgl_kembali'] . '</td>
                        <td>' . self::calculateDenda($transaksi['tgl_kembali']) . '</td>
                    </tr>';
        }
        $content .= '</table>';

        // Tambahkan konten ke halaman PDF
        $pdf->writeHTML($content, true, false, true, false, '');

        // Outputkan dokumen PDF sebagai unduhan
        $namafile = 'laporan_transaksi_' . date('d-m-Y') . '.pdf';

        // Outputkan dokumen PDF sebagai unduhan dengan nama file sesuai tanggal hari ini
        $pdf->Output($namafile, 'D');
    }
}
