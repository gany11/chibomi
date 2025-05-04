<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class PaymentsModel extends Model
{
    protected $table            = 'payments';
    protected $primaryKey       = 'id_payments';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_payments',
        'id_transaksi',
        'midtrans_transaction_id',
        'payment_method',
        'status_pembayaran',
        'amount',
        'fee',
        'paid_at',
    ];
}
