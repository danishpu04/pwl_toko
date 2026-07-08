<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\DiscountModel;

class Home extends BaseController
{
    protected $productModel;

    function __construct()
    {
        helper(['number', 'form']); // tambahan, untuk form helper
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $products = $this->productModel->findAll();
        
        $discountModel = new DiscountModel();
        $activeDiscount = $discountModel->where('tanggal', date('Y-m-d'))->first();

        $data = [
            'products' => $products,
            'activeDiscount' => $activeDiscount
        ];

        return view('v_home', $data);
    }

    public function contact(): string
    {
        return view('v_contact');
    }
}
