<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormValidator;
use App\Services\CompaniesHouse\Repository as CompaniesHouse;

class HomeController extends Controller
{
    /**
     * Displays the form page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Handles the POST request to do the calculation
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getInsurred(FormValidator $request)
    {
        $data = (new CompaniesHouse())->checkIfInsuranceIsAvailable($request->input());

        return view('welcome')->with($data);
    }
}
