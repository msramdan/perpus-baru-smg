<?php

namespace App\Models;

use CodeIgniter\Model;

class LogPinjamKembaliModel extends Model
{
    protected $table = 'logpinjamkembali';
    protected $primaryKey = 'id';
    protected $allowedFields = ['isbn', 'judul', 'nomor', 'nama', 'kelas', 'tgl_pinjam', 'tgl_kembali', 'status', 'tgl_dibuat'];

    public function getLogPinjamKembali($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }

    public function saveLog($data)
    {
        return $this->insert($data);
    }

    public function search($keyword)
    {
        return $this->table('logpinjamkembali')->like('isbn', $keyword)->orLike('nomor', $keyword)->orLike('judul', $keyword)->orLike('nama', $keyword);
    }

    public function getDaftarPeminjamByJudul($judul)
    {
        return $this->db->table('pinjamkembali')
            ->select('nama, kelas, tgl_pinjam, tgl_kembali')
            ->where('judul', $judul)
            ->get()
            ->getResultArray();
    }
    public function getPeminjamanByJudul($judul)
    {
        return $this->where('judul', $judul)->findAll();
    }

    public function getJumlahPeminjamanByJudul($judul)
    {
        return $this->db->table('pinjamkembali')
            ->where('judul', $judul)
            ->countAllResults();
    }
}
