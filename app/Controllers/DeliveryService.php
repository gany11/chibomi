<?php

namespace App\Controllers;

use App\Models\DeliveryServiceModel;
use CodeIgniter\Controller;
use Ramsey\Uuid\Uuid;

class DeliveryService extends BaseController
{
    protected $deliveryServiceModel;

    public function __construct()
    {
        $this->deliveryServiceModel = new DeliveryServiceModel();
    }


    public function indexListDeliveryService()
    {
        $delivery = $this->deliveryServiceModel->findAll();

        return view('admin/chibomi/list-delivery-service', ['delivery' => $delivery]);
    }

    public function indexAddDeliveryService()
    {
        return view('admin/chibomi/form-delivery-service', [
            'errors' => session()->getFlashdata('errors'),
            'error' => session()->getFlashdata('error')
        ]);
    }

    public function indexDeliveryService($id = null)
    {
        if ($id) {
            $delivery = $this->deliveryServiceModel->find($id);
            $title = 'Edit Jasa Pengiriman';

            if (!$delivery) {
                return redirect()->back()->with('message', 'Data pengiriman tidak ditemukan.');
            }
        } else {
            $delivery = null;
            $title = 'Tambah Jasa Pengiriman';
        }

        return view('admin/chibomi/form-delivery-service', [
            'delivery' => $delivery,
            'title' => $title,
            'errors' => session('errors') ?? []
        ]);
    }

    public function saveAddDeliveryService()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama' => [
                'label' => 'Nama Layanan',
                'rules' => 'required|string|max_length[255]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'string' => '{field} harus berupa teks.',
                    'max_length' => '{field} maksimal 255 karakter.'
                ]
            ],
            'kode' => [
                'label' => 'Kode Layanan',
                'rules' => 'required|string|max_length[50]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'string' => '{field} harus berupa teks.',
                    'max_length' => '{field} maksimal 50 karakter.'
                ]
            ],
            'status' => [
                'label' => 'Status',
                'rules' => 'required|in_list[Aktif,Pasif]',
                'errors' => [
                    'required' => '{field} harus dipilih.',
                    'in_list' => '{field} harus berupa Aktif atau Pasif.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'kode' => $this->request->getPost('kode'),
            'status' => $this->request->getPost('status'),
        ];

        $id = $this->request->getPost('id');

        if ($id) {
            // UPDATE
            $this->deliveryServiceModel->update($id, $data);
            return redirect()->to('/admin/pengiriman/list')->with('message', 'Layanan pengiriman berhasil diperbarui.');
        } else {
            // INSERT
            $data['id_delivery_service'] = Uuid::uuid4()->toString();
            $this->deliveryServiceModel->insert($data);
            return redirect()->to('/admin/pengiriman/list')->with('message', 'Layanan pengiriman berhasil ditambahkan.');
        }
    }

}