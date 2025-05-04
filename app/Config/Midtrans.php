<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Midtrans extends BaseConfig
{
    public $serverKey = KEY_MIDTRANS_SERVER;
    public $isProduction = false; // Ubah ke true untuk mode produksi
}
