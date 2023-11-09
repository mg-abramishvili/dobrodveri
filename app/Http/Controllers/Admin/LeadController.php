<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lead;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        return Lead::orderBy('created_at', 'desc')->get();
    }

    public function lead($id)
    {
        return Lead::find($id);
    }
}
