<?php

namespace App\Controllers;

use App\Models\AddressModel;
use CodeIgniter\Controller;
use Ramsey\Uuid\Uuid;
use CodeIgniter\API\ResponseTrait;

class Address extends BaseController
{
    use ResponseTrait;
    protected $addressModel;

    public function __construct()
    {
        $this->addressModel = new AddressModel();
    }
    
    // ALamat Pengguna
    public function indexAlamat()
    {
        // Ambil ID akun dari session
        $id_account = session()->get('id_account');
    
        // Ambil semua alamat milik user
        $alamat = $this->addressModel->where('id_account', $id_account)->findAll();

        $data = [
            'alamat' => $alamat,
        ];

        return view('account/alamat',$data);
    }

    public function indexTambahAlamat()
    {
        return view('account/form-alamat', [
            'alamat' => '',
            'errors' => session()->getFlashdata('errors')
        ]);
    }

    public function indexEditAlamat($id)
    {
        $session = session();
        $id_account = $session->get('id_account');

        $alamat = $this->addressModel->find($id);

        if (!$alamat) {
            return redirect()->to('/alamat')->with('error', 'Alamat tidak ditemukan.');
        }

        if ($alamat['id_account'] !== $id_account) {
            return redirect()->to('/alamat')->with('error', 'Anda tidak memiliki izin untuk menghapus alamat ini.');
        }

        return view('account/form-alamat', [
            'alamat' => $alamat,
            'errors' => session()->getFlashdata('errors')
        ]);
    }


    public function saveAlamat()
    {
        $session = session();
        $data = $this->request->getPost();
        $data['id_account'] = $session->get('id_account');
        $id = $data['id_address'] ?? null;

        if ($id) {
            $alamat = $this->addressModel->find($id);
            if (!$alamat) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Alamat tidak ditemukan');
            }
            if (!$this->addressModel->update($id, $data)) {
                return redirect()->back()->withInput()->with('errors', $this->addressModel->errors());
            }
            return redirect()->to('/alamat')->with('success', 'Alamat berhasil diperbarui.');
        } else {
            // INSERT
            try {
                if (!$this->addressModel->insert($data)) {
                    return redirect()->back()->withInput()->with('errors', $this->addressModel->errors());
                }
                return redirect()->to('/alamat')->with('success', 'Alamat berhasil disimpan.');
            } catch (\RuntimeException $e) {
                return redirect()->to('/alamat')->with('error', $e->getMessage());
            }
        }
    }

    public function deleteAlamat($id)
    {
        $session = session();
        $id_account = $session->get('id_account');

        $alamat = $this->addressModel->find($id);

        if (!$alamat) {
            return redirect()->to('/alamat')->with('error', 'Alamat tidak ditemukan.');
        }

        if ($alamat['id_account'] !== $id_account) {
            return redirect()->to('/alamat')->with('error', 'Anda tidak memiliki izin untuk menghapus alamat ini.');
        }

        if (!$this->addressModel->delete($id)){
            return redirect()->to('/alamat')->with('error', 'Alamat tidak berhasil dihapus.');
        }

        return redirect()->to('/alamat')->with('success', 'Alamat berhasil dihapus.');
    }

    public function cekKodePos($kodePos = null)
    {
        helper('constants');

        if (!$kodePos) {
            return $this->fail('Kode pos wajib diisi', 400);
        }

        $client = \Config\Services::curlrequest();

        try {
            $response = $client->get(
                'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search=' . $kodePos,
                [
                    'headers' => [
                        'accept' => 'application/json',
                        'key' => KEY,
                    ]
                ]
            );

            $body = json_decode($response->getBody(), true);

            if (!empty($body['data'][0])) {
                $data = $body['data'][0];
                return $this->respond($data, 200);
            } else {
                return $this->failNotFound('Kode pos tidak ditemukan');
            }

        } catch (\Exception $e) {
            return $this->failServerError('Gagal menghubungi API: ' . $e->getMessage());
        }
    }
}
