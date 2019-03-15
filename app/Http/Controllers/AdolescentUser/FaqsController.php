<?php

namespace App\Http\Controllers\AdolescentUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqsController extends Controller
{
    public function index()
    {
        $operand    = \Auth::user()->operands()->firstOrFail();
        $faqs       = \App\Faq::where('operand_id', $operand->id)->with(['faqCategory', 'user'])->get();

        return response()->json($faqs, 200);
    }
}
