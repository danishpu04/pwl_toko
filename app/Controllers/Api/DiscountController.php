<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\DiscountModel;

class DiscountController extends ResourceController
{
    protected $modelName = 'App\Models\DiscountModel';
    protected $format    = 'json';

    public function index()
    {
        $discounts = $this->model->orderBy('tanggal', 'DESC')->findAll();
        return $this->respond([
            'status' => 200,
            'error'  => null,
            'data'   => $discounts
        ]);
    }

    public function create()
    {
        $rules = [
            'tanggal' => [
                'rules' => 'required|valid_date|is_unique[discount.tanggal]',
                'errors' => [
                    'is_unique' => 'Diskon untuk tanggal ini sudah ada.'
                ]
            ],
            'nominal' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'tanggal' => $this->request->getVar('tanggal'),
            'nominal' => $this->request->getVar('nominal'),
        ];

        $this->model->insert($data);
        $data['id'] = $this->model->getInsertID();

        return $this->respondCreated([
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data diskon berhasil ditambahkan'
            ],
            'data'     => $data
        ]);
    }
}
