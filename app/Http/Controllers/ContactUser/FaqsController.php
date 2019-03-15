<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqsController extends Controller
{
    public function index()
    {
        $faqs = \App\Faq::get();

        return response()->json($faqs, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required|string|max:255',
            'description'       => 'required|string|max:255',
            'color'             => 'string|max:255',
            'faq_category_id'   => 'required|string|max:255'
        ]);

        $faq = \App\Faq::create([
            'name'              => $request->input('name'),
            'description'       => $request->input('description'),
            'color'             => $request->input('color'),
            'faq_category_id'   => $request->input('faq_category_id'),
            'user_id'           => \Auth::id(),
        ]);

        return response()->json($faq, 200);
    }

    public function show($id)
    {
        $faq = \App\Faq::with('faqCategory')->findOrFail($id);

        return response()->json($faq, 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'              => 'required|string|max:255',
            'description'       => 'required|string|max:255',
            'color'             => 'string|max:255',
            'faq_category_id'   => 'required|string|max:255'
        ]);

        $faq = \App\Faq::findOrFail($id);

        $faq->update([
            'name'              => $request->input('name'),
            'description'       => $request->input('description'),
            'color'             => $request->input('color'),
            'faq_category_id'   => $request->input('faq_category_id'),
            'user_id'           => \Auth::id()
        ]);

        $faq = $faq->with('faqCategory')->firstOrFail();

        return response()->json($faq, 200);
    }

    public function destroy($id)
    {
        $faq = \App\Faq::findOrFail($id);
        $faq->delete();

        return response()->json($faq, 200);
    }
}
