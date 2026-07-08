<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiscountModel;

class DiscountController extends BaseController
{
    protected $discountModel;

    public function __construct()
    {
        helper('form');
        $this->discountModel = new DiscountModel();
    }

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        if (session()->get('role') != 'admin') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function index()
    {
        $discounts = $this->discountModel->orderBy('tanggal', 'DESC')->findAll();
        return view('discount/index', ['discounts' => $discounts]);
    }

    public function create()
    {
        $rules = [
            'tanggal' => [
                'rules' => 'required|valid_date|is_unique[discount.tanggal]',
                'errors' => [
                    'is_unique' => 'Diskon untuk tanggal ini sudah ada. Pilih tanggal lain.'
                ]
            ],
            'nominal' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('failed', $this->validator->listErrors());
        }

        $this->discountModel->insert([
            'tanggal' => $this->request->getPost('tanggal'),
            'nominal' => $this->request->getPost('nominal'),
        ]);

        return redirect()->to('diskon')->with('success', 'Data Diskon Berhasil Ditambah');
    }

    public function edit($id)
    {
        $rules = [
            'nominal' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('failed', $this->validator->listErrors());
        }

        $this->discountModel->update($id, [
            'nominal' => $this->request->getPost('nominal'),
        ]);

        return redirect()->to('diskon')->with('success', 'Data Diskon Berhasil Diubah');
    }

    public function delete($id)
    {
        $this->discountModel->delete($id);
        return redirect()->to('diskon')->with('success', 'Data Diskon Berhasil Dihapus');
    }
}
