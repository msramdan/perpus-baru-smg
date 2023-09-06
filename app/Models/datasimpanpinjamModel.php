<?php

namespace App\Models;

use CodeIgniter\Model;

class DataSimpanPinjamModel extends Model
{
    protected $table      = 'simpanpinjam';
    protected $primaryKey = 'id';
    protected $allowedFields = ['isbn', 'judul', 'jumlah',  'nomor', 'nama', 'kelas',  'tgl_pinjam', 'tgl_kembali'];

    public function getDataSimpanPinjam($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }

    public function search($keyword)
    {
        return $this->table('simpanpinjam')->like('isbn', $keyword)->orLike('nomor', $keyword)->orLike('judul', $keyword)->orLike('nama', $keyword);
    }

    public function getDaftarPeminjamByJudul($judul)
    {
        return $this->db->table('simpanpinjam')
            ->select('nama, kelas, tgl_pinjam, tgl_kembali')
            ->where('judul', $judul)
            ->get()
            ->getResultArray();
    }
}
