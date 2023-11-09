<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'subject' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'message' => 'required',
        ];

        $this->validate($request, $rules);

        $lead = new Lead();

        $lead->subject = $request->subject;
        $lead->name = $request->name;
        $lead->phone = $request->phone;
        $lead->message = $request->message;

        $lead->save();
    }
}
