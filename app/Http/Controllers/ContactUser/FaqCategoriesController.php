<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqCategoriesController extends Controller
{
    public function index()
    {
        $faqCategories = \App\FaqCategory::get();

        return response()->json($faqCategories, 200);
    }
}
