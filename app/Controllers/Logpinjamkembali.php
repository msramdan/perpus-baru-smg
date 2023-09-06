<?php

namespace App\Controllers;

use App\Models\logpinjamkembaliModel;
use App\Models\bukuModel;
use App\Models\anggotaModel;
use TCPDF;
use \DateTime;

class LogpinjamKembali extends BaseController
{
    protected $logpinjamkembaliModel;
    protected $helpers = ['form'];
    protected $bukuModel;
    protected $anggotaModel;

    public function __construct()
    {
        $this->logpinjamkembaliModel = new logpinjamkembaliModel();
        $this->bukuModel = new bukuModel();
        $this->anggotaModel = new anggotaModel();
    }

    public function index()
    {
        $keywork = $this->request->getVar('keywork');
        if ($keywork) {
            $logpinjamkembali = $this->logpinjamkembaliModel->search($keywork);
        } else {
            $logpinjamkembali = $this->logpinjamkembaliModel;
        }
        // $pinjamkembaliModel = new pinjamkembaliModel();

        // return view('pinjamkembali/index', $data);
        $data = [
            'title' => 'Riwayat Transaksi Buku',
            'logpinjamkembali' => $this->logpinjamkembaliModel->getLogPinjamKembali(),
            'buku' => $this->bukuModel->getBuku(),
            'anggota' => $this->anggotaModel->getAnggota()
        ];

        // menampilkan view
        return view('logpinjamkembali/index', $data);
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
    public function delete($id)
    {
        $logpinjamkembali = $this->logpinjamkembaliModel->find($id);

        $this->logpinjamkembaliModel->delete($id);
        session()->setFlashdata('pesan', 'Riwayat Transaksi Berhasil dihapus.');
        return redirect()->to('/logpinjamkembali/index');
    }
    public function cetakLaporan()
    {
        // Ambil data transaksi dari model
        $data['status'] = $this->logpinjamkembaliModel->getLogPinjamKembali();

        // Buat objek TCPDF
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8');

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
            <th>Transaksi</th>
            <th>Tanggal Transaksi</th>
        </tr>';
        $i = 1;
        foreach ($data['status'] as $transaksi) {
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
                        <td>' . $transaksi['status'] . '</td>
                        <td>' . $transaksi['tgl_dibuat'] . '</td>
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
