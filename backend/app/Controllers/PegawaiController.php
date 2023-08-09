<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pegawai;

class PegawaiController extends BaseController
{
    public function create()
    {
        $rules = [
            'nama_pegawai' => 'required',
            'foto' => [
                'rules' => 'uploaded[foto]|is_image[foto]|ext_in[foto,jpg,png,jpeg]',
                'errors' => [
                    'uploaded' => 'Harap pilih foto.',
                    'is_image' => 'Berkas harus berupa gambar.',
                    'ext_in' => 'Ekstensi file yang diizinkan: jpg, png, jpeg.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->response->setJSON(['error' => $validationErrors])->setStatusCode(400);
        }

        $namaPegawai = $this->request->getPost('nama_pegawai');
        $foto = $this->request->getFile('foto');

        $newFileName = $foto->getRandomName();
        $foto->move(ROOTPATH . 'public/uploads', $newFileName);
        $fotoPath = 'uploads/' . $newFileName;

        $pegawaiModel = new Pegawai();
        $pegawaiData = [
            'nama_pegawai' => $namaPegawai,
            'foto' => $fotoPath
        ];
        $pegawaiModel->insert($pegawaiData);

        return $this->response->setJSON(['message' => 'Data pegawai berhasil ditambahkan']);
    }

    public function update($id)
    {
        $rules = [
            'nama_pegawai' => 'required'
        ];

        if ($this->request->getFile('foto')) {
            $rules['foto'] = 'uploaded[foto]|is_image[foto]|ext_in[foto,jpg,png,jpeg]';
        }

        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->response->setJSON(['error' => $validationErrors])->setStatusCode(400);
        }

        $namaPegawai = $this->request->getVar('nama_pegawai');
        $foto = $this->request->getFile('foto');

        $pegawaiModel = new Pegawai();
        $pegawaiData = [
            'nama_pegawai' => $namaPegawai
        ];

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $newFileName = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/uploads', $newFileName);
            $fotoPath = 'uploads/' . $newFileName;
            $pegawaiData['foto'] = $fotoPath;
        }

        $pegawaiModel->update($id, $pegawaiData);

        return $this->response->setJSON(['message' => 'Data pegawai berhasil diperbarui']);
    }

    public function get($id)
    {
        $pegawaiModel = new Pegawai();
        $pegawai = $pegawaiModel->find($id);

        if ($pegawai) {
            return $this->response->setJSON($pegawai);
        } else {
            return $this->response->setJSON(['error' => 'Data pegawai tidak ditemukan'])->setStatusCode(400);
        }
    }

    public function getAll()
    {
        $pegawaiModel = new Pegawai();
        $pegawaiList = $pegawaiModel->findAll();

        return $this->response->setJSON(['data' => $pegawaiList]);
    }

    public function delete($id)
    {
        $pegawaiModel = new Pegawai();
        $pegawaiModel->delete($id);

        return $this->response->setJSON(['message' => 'Data pegawai berhasil dihapus']);
    }

}