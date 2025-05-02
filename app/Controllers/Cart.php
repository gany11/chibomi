<?php

namespace App\Controllers;

use App\Models\CartModel;
use CodeIgniter\Controller;
use Ramsey\Uuid\Uuid;

class Cart extends BaseController
{
    protected $cartModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
    }
    
    // Keranjang
    public function indexKeranjang()
    {
        $session = session();
        $idAccount = $session->get('id_account');

        $cartItems = $this->cartModel->getCartWithProduct($idAccount);

        return view('cart/keranjang', [
            'cartItems' => $cartItems,
        ]);
    }

    public function addToCart()
    {
        $session = session();
        $idAccount = $session->get('id_account');
        $productId = $this->request->getPost('product_id');
        $qty = (int)$this->request->getPost('qty');

        if (!$idAccount) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($qty < 1) {
            return redirect()->back()->with('error', 'Jumlah tidak valid.');
        }

        // Cek apakah produk sudah ada di keranjang
        $existing = $this->cartModel
            ->where('id_account', $idAccount)
            ->where('id_product', $productId)
            ->first();

        if ($existing) {
            // Jika sudah ada, update jumlah
            $this->cartModel->update($existing['id_cart'], [
                'qty' => $existing['qty'] + $qty
            ]);
        } else {
            // Tambah ke keranjang
            $this->cartModel->insert([
                'id_account' => $idAccount,
                'id_product' => $productId,
                'qty' => $qty
            ]);
        }

        return redirect()->to('/keranjang')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function ajaxUpdateQty()
    {
        $id_cart = $this->request->getPost('id_cart');
        $qty = (int) $this->request->getPost('qty');

        if (!$id_cart || $qty < 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak valid.'
            ]);
        }

        $cartItem = $this->cartModel->find($id_cart);

        if (!$cartItem) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Item tidak ditemukan.'
            ]);
        }

        if ($qty === 0) {
            $this->cartModel->delete($id_cart);
            session()->setFlashdata('success', 'Item berhasil dihapus.');
            return $this->response->setJSON(['success' => true, 'message' => 'Item berhasil dihapus.']);
        }

        if ($qty > $cartItem['stok']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Jumlah melebihi stok yang tersedia.'
            ]);
        }

        $this->cartModel->update($id_cart, ['qty' => $qty]);
        session()->setFlashdata('success', 'Jumlah produk berhasil diperbarui.');
        return $this->response->setJSON(['success' => true, 'message' => 'Jumlah produk berhasil diperbarui.']);
    }

    public function delete()
    {
        $id_cart = $this->request->getPost('id_cart');

        if (!$id_cart) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID tidak ditemukan'
            ]);
        }

        if ($this->cartModel->delete($id_cart)) {
            session()->setFlashdata('success', 'Item berhasil dihapus.');
            return $this->response->setJSON(['success' => true]);
        } else {
            session()->setFlashdata('error', 'Gagal menghapus item.');
            return $this->response->setJSON(['success' => false]);
        }
    }

}
