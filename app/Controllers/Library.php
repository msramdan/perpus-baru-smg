<?php

namespace App\Controllers;

use App\Models\bukuModel;
use App\Models\anggotaModel;
use App\Models\pinjamkembaliModel;
use IntlDateFormatter;

class Library extends BaseController
{
    public function index()
    {
        $bukuModel = new bukuModel();
        $anggotaModel = new anggotaModel();
        $pinjamkembaliModel = new pinjamkembaliModel();
        $data = [
            'title' => 'Dashboard Admin',
            'hari' => $this->getHariIndonesia(date('N')),
            'tanggal' => $this->getTanggalIndonesia(date('Y-m-d')),
            'jumlah_buku' => $bukuModel->countAll(),
            'jumlah_anggota' => $anggotaModel->countAll(),
            'jumlah_transaksi' => $pinjamkembaliModel->countAll()
        ];
        return view('library/home', $data);
    }

    private function getHariIndonesia($hariInggris)
    {
        $hari = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu'
        ];

        return $hari[$hariInggris];
    }

    private function getBulanIndonesia($bulanInggris)
    {
        $bulan = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        return $bulan[$bulanInggris];
    }

    private function getTanggalIndonesia($tanggal)
    {
        $tanggalFormat = date_create($tanggal);
        $formatter = new IntlDateFormatter(
            'id_ID',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE
        );

        $formatter->setPattern("d MMMM y");
        $tanggalIndonesia = $formatter->format($tanggalFormat);

        $bulanInggris = date('F', strtotime($tanggal));
        $bulanIndonesia = $this->getBulanIndonesia($bulanInggris);
        $tanggalIndonesia = str_replace($bulanInggris, $bulanIndonesia, $tanggalIndonesia);

        return $tanggalIndonesia;
    }
}
