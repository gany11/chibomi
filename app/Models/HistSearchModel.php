<?php

namespace App\Models;

use CodeIgniter\Model;

class HistSearchModel extends Model
{
    protected $table      = 'hist_search';
    protected $primaryKey = 'id_hist_search';
    protected $allowedFields = ['id_hist_search', 'id_account', 'tanggal', 'search'];
    protected $useTimestamps = false;

    // Validation rules
    protected $validationRules = [
        'id_hist_search' => 'required|is_unique[hist_search.id_hist_search]|max_length[36]',
        'id_account'     => 'required|max_length[36]',
        'tanggal'        => 'required|valid_date',
        'search'         => 'required|max_length[255]',
    ];

    protected $validationMessages = [
        'id_hist_search' => [
            'required' => 'ID History Search is required.',
            'is_unique' => 'This ID already exists.',
            'max_length' => 'ID History Search must not exceed 36 characters.',
        ],
        'id_account' => [
            'required' => 'Account ID is required.',
            'max_length' => 'Account ID must not exceed 36 characters.',
        ],
        'tanggal' => [
            'required' => 'Date is required.',
            'valid_date' => 'Please enter a valid date.',
        ],
        'search' => [
            'required' => 'Search keyword is required.',
            'max_length' => 'Search keyword must not exceed 255 characters.',
        ]
    ];

    protected $skipValidation = false;

    public function getHistSearch($id_hist_search = null)
    {
        if ($id_hist_search) {
            return $this->where('id_hist_search', $id_hist_search)->first();
        }
        return $this->findAll();
    }
}
