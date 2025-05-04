<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CartModel;
use App\Models\StockModel;
use CodeIgniter\Controller;
use Ramsey\Uuid\Uuid;

class Cart extends BaseController
{
    protected $cartModel;
    protected $stockModel;
    protected $productModel;

    public function __construct()
    {
        $this->stockModel = new StockModel();
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
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

        $produk = $this->productModel
            ->where('id_product', $productId)
            ->where('deleted_at', null)
            ->where('drafted_at', null)
            ->first();

        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak valid.');
        }

        if ($qty < 1) {
            return redirect()->back()->with('error', 'Jumlah tidak valid.');
        }

        if ($produk['jenis'] === "Barang") {
            $stokTersedia = $this->stockModel
                ->where('id_product', $productId)
                ->where('perubahan_stock !=', 0)
                ->selectSum('perubahan_stock')
                ->first();

            $stok = $stokTersedia['perubahan_stock'] ?? 0;

            $existing = $this->cartModel
                ->where('id_account', $idAccount)
                ->where('id_product', $productId)
                ->first();

            $totalQtySetelahTambah = $qty + ($existing['qty'] ?? 0);

            if ($totalQtySetelahTambah > $stok) {
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
            }
        }

        $existing = $this->cartModel
            ->where('id_account', $idAccount)
            ->where('id_product', $productId)
            ->first();

        if ($existing) {
            $this->cartModel->update($existing['id_cart'], [
                'qty' => $existing['qty'] + $qty
            ]);
        } else {
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

        if (!$id_cart || !is_numeric($qty) || $qty < 0) {
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

        $produk = $this->productModel
            ->where('id_product', $cartItem['id_product'])
            ->first();

        if (!$produk) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Produk tidak ditemukan.'
            ]);
        }

        if ($produk['jenis'] === 'Barang') {
            $stokTersedia = $this->stockModel
                ->where('id_product', $cartItem['id_product'])
                ->where('perubahan_stock !=', 0)
                ->selectSum('perubahan_stock')
                ->first();

            $stok = (int) ($stokTersedia['perubahan_stock'] ?? 0);

            if ($qty > $stok) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Jumlah melebihi stok yang tersedia.'
                ]);
            }
        }

        if ($qty === 0) {
            $this->cartModel->delete($id_cart);
            session()->setFlashdata('success', 'Item berhasil dihapus.');
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Item berhasil dihapus.'
            ]);
        }

        $this->cartModel->update($id_cart, ['qty' => $qty]);
        session()->setFlashdata('success', 'Jumlah produk berhasil diperbarui.');
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Jumlah produk berhasil diperbarui.'
        ]);
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
