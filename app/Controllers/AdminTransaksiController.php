<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class AdminTransaksiController extends BaseController
{
    protected $transactionModel;
    protected $transactionDetailModel;

    public function __construct()
    {
        helper(['number', 'form']);
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
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
        $transactions = $this->transactionModel->orderBy('created_at', 'DESC')->findAll();
        $transactionIds = array_column($transactions, 'id');
        $products = $this->transactionDetailModel->getProductsByTransactionIds($transactionIds);

        return view('admin_transaksi/index', [
            'transactions' => $transactions,
            'products'     => $products
        ]);
    }

    public function update_status($id)
    {
        $status = $this->request->getPost('status');
        
        $this->transactionModel->update($id, [
            'status' => $status
        ]);

        return redirect()->to('admin-transaksi')->with('success', 'Status transaksi berhasil diperbarui.');
    }
}
