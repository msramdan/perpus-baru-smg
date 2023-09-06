<?php

namespace App\Controllers;

use App\Models\bukuModel;

use App\Models\pinjamkembaliModel;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

use CodeIgniter\Exceptions\PageNotFoundException;

use Endroid\QrCode\QrCode;

use Endroid\QrCode\Writer\PngWriter;


class Buku extends BaseController
{
    protected $bukuModel;
    protected $pinjamkembaliModel;
    protected $helpers = ['form'];
    public function __construct()
    {
        $this->bukuModel = new bukuModel();
        $this->pinjamkembaliModel = new pinjamkembaliModel();
    }

    public function index()
    {
        $keywork = $this->request->getVar('keywork');
        if ($keywork) {
            $buku = $this->bukuModel->search($keywork);
        } else {
            $buku = $this->bukuModel;
        }
        //$buku = $this->bukuModel->findAll();
        $data = [
            'title' => 'Kelola Buku',
            'buku' => $this->bukuModel->getBuku()
        ];

        return view('buku/index', $data);
    }

    public function import()
    {
        if (!$this->validate([
            'import_file' => [
                'uploaded[import_file]',
                'mime_in[import_file,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet]',
                'max_size[import_file,10240]',
            ]
        ])) {
            return redirect()->to('/buku')->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('import_file');
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $bukuModel = new BukuModel();
        foreach ($rows as $row) {
            $data = [
                'isbn' => $row[0],
                'gambar' => empty($row[1]) ? 'default.png' : $row[1], // Jika kolom gambar kosong, isi dengan 'default.png'
                'judul' => $row[2],
                'penulis' => $row[3],
                'penerbit' => $row[4],
                'jenis' => $row[5],
                'tahun' => $row[6],
                'halaman' => $row[7],
                'jumlah' => $row[8],
                'lokasi' => $row[9],
                'slug' => url_title($row[2], '-', true)
            ];
            $bukuModel->insert($data);
        }

        session()->setFlashdata('pesan', 'Buku Berhasil ditambahkan.');

        return redirect()->to('/buku');
    }

    // ...



    public function detail($slug)
    {
        $buku = $this->bukuModel->getBuku($slug);
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
        return view('buku/detail', $data);
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


    public function create()
    {
        $data = [
            'title' => 'Tambah Data Buku',
            'validation' => \Config\Services::validation()
        ];

        return view('buku/create', $data);
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Ubah Data Buku',
            'validation' => \Config\Services::validation(),
            'buku' => $this->bukuModel->getBuku($slug)
        ];

        return view('buku/edit', $data);
    }


    public function save()
    {
        //validasi input buku
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[buku.judul]',
                'errors' => [
                    'required' => '{field} buku harus sudah diisi.',
                    'is_unique' => '{field} buku sudah tersedia.'
                ]
            ],
            'gambar' => [
                'rules' => 'is_image[gambar]|max_size[gambar,10240]',
                'errors' => [
                    'is_image' => 'File yang diupload harus gambar (JPEG,JPG,PNG)',
                    'max_size' => 'Ukuran gambar tidak boleh melebihi 10mb'
                ]
            ]
        ])) {
            //$validation = \Config\Services::validation();
            //return redirect()->to('/buku/create')->withInput()->with('validation', $validation);
            return redirect()->to('/buku/create')->withInput();
        }
        //Untuk mengambl gambil gambar
        $fileGambar = $this->request->getFile('gambar');

        //Apabila tidak upload gambar
        if ($fileGambar->getError() == 4) {
            $namaGambar = 'default.png';
        } else {
            //Untuk memindahkan file
            $fileGambar->move('img');
            //Untuk mengambil nama file
            $namaGambar = $fileGambar->getName();
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->bukuModel->save([
            'isbn' => $this->request->getVar('isbn'),
            'gambar' => $namaGambar,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'jenis' => $this->request->getVar('jenis'),
            'tahun' => $this->request->getVar('tahun'),
            'halaman' => $this->request->getVar('halaman'),
            'jumlah' => $this->request->getVar('jumlah'),
            'lokasi' => $this->request->getVar('lokasi')
        ]);

        session()->setFlashdata('pesan', 'Buku Berhasil ditambahkan.');

        return redirect()->to('/buku');
    }

    public function delete($id)
    {
        //mencari gambar yang akan dihapus
        $buku = $this->bukuModel->find($id);
        //agar tidak menghapus gambar default
        if ($buku['gambar'] != 'default.png') {
            //untuk menghapus gambar
            unlink('img/' . $buku['gambar']);
        }

        $this->bukuModel->delete($id);
        session()->setFlashdata('pesan', 'Buku Berhasil dihapus.');
        return redirect()->to('/buku');
    }

    public function update($id)
    {
        //cek judul
        $bukuLama = $this->bukuModel->getBuku($this->request->getVar('slug'));
        if ($bukuLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[buku.judul]';
        }
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} buku harus sudah diisi.',
                    'is_unique' => '{field} buku sudah tersedia.'
                ]
            ],
            'gambar' => [
                'rules' => 'is_image[gambar]|max_size[gambar,10240]',
                'errors' => [
                    'is_image' => 'File yang diupload harus gambar (JPEG,JPG,PNG)',
                    'max_size' => 'Ukuran gambar tidak boleh melebihi 10mb'
                ]
            ]
        ])) {
            return redirect()->to('/buku/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $fileGambar = $this->request->getFile('gambar');

        //Untuk mengecek gambar, apa masih gambar lama atau tidak
        if ($fileGambar->getError() == 4) {
            $namaGambar = $this->request->getVar('gambarLama');
        } else {
            //mengambil nama gambar lama
            $namaGambar = $fileGambar->getName();

            $fileGambar->move('img');
            // Untuk menghapus file yang lama
            if ($this->request->getVar('gambarLama') != 'default.png') {
                unlink('img/' . $this->request->getVar('gambarLama'));
            }
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->bukuModel->save([
            'id' => $id,
            'isbn' => $this->request->getVar('isbn'),
            'gambar' => $namaGambar,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'jenis' => $this->request->getVar('jenis'),
            'tahun' => $this->request->getVar('tahun'),
            'halaman' => $this->request->getVar('halaman'),
            'jumlah' => $this->request->getVar('jumlah'),
            'lokasi' => $this->request->getVar('lokasi')
        ]);
        session()->setFlashdata('pesan', 'Buku Berhasil diubah.');

        return redirect()->to('/buku');
    }
}
