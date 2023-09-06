<?php

namespace App\Controllers;

use App\Models\databukuModel;

use App\Models\pinjamkembaliModel;

use CodeIgniter\Exceptions\PageNotFoundException;

use Endroid\QrCode\QrCode;

use Endroid\QrCode\Writer\PngWriter;

class Databuku extends BaseController
{
    protected $databukuModel;
    protected $pinjamkembaliModel;
    public function __construct()
    {
        $this->pinjamkembaliModel = new pinjamkembaliModel();
        $this->databukuModel = new databukuModel();
    }

    public function index()
    {
        $keywork = $this->request->getVar('keywork');
        if ($keywork) {
            $buku = $this->databukuModel->search($keywork);
        } else {
            $buku = $this->databukuModel;
        }
        //$databuku = $this->databukuModel->findAll();
        $data = [
            'title' => 'Daftar Buku',
            'buku' => $this->databukuModel->getBuku()
        ];

        return view('databuku/index', $data);
    }

    public function detail($slug)
    {
        $buku = $this->databukuModel->getBuku($slug);
        $pinjamkembali = $this->pinjamkembaliModel->getPinjamKembali();
        $qrCode = $this->generateQrCode($buku);
        $jumlahPeminjaman = $this->pinjamkembaliModel->getJumlahPeminjamanByJudul($buku['judul']);
        $jumlahStok = $buku['jumlah'];
        $daftarPeminjam = $this->pinjamkembaliModel->getDaftarPeminjamByJudul($buku['judul']);

        $data = [
            'title' => 'Detail Buku',
            'buku' => $buku,
            'qrCode' => $qrCode,
            'jumlahPeminjaman' => $jumlahPeminjaman,
            'jumlahStok' => $jumlahStok,
            'daftarPeminjam' => $daftarPeminjam
        ];
        // return view('buku/detail', $data);
        // $data = [
        //     'title' => 'Detail Buku',
        //     'buku' => $this->bukuModel->getBuku($slug)
        // ];
        //jika buku tidak terdapat di tabel
        return view('databuku/detail', $data);
    }

    public function generateQrCode($buku)
    {
        // Memasukkan Informasi yang akan ditampilkan di QR Code
        $informasi = [
            'Jumlah Peminjaman' => $this->pinjamkembaliModel->getJumlahPeminjamanByJudul($buku['judul']),
            'Jumlah Stok Tersisa' => $buku['jumlah'],
            'Lokasi Buku' => $buku['lokasi'],
            'Daftar Peminjam' => $this->pinjamkembaliModel->getDaftarPeminjamByJudul($buku['judul'])
        ];

        // Menghasilkan QR code sebagai string dengan informasi yang ditambahkan
        $qrCode = new QrCode(json_encode($informasi));

        // Mengatur ukuran QR code (opsional)
        $qrCode->setSize(250);

        // Membuat penulis PNG
        $writer = new PngWriter();

        // Menghasilkan QR code sebagai string dengan format PNG
        $imageData = $writer->write($qrCode)->getString();

        // Mengembalikan QR code sebagai string
        return 'data:image/png;base64,' . base64_encode($imageData);
    }
}
