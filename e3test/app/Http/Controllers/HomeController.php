<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime; // or Carbon
use App\Rates;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller {

    public function index() {

        $rates = Rates::orderBy('date', 'asc')
                ->get();

        return view('home.index', [
            'rates' => $rates,
        ]);
    }

    public function getRate(Request $request) {


        $lastYear = new DateTime();
        $lastYear->modify('-1 year');

        $request->validate([
            'dob' => 'required|date|before_or_equal:today|after_or_equal:' . $lastYear->format('Y-m-d')
        ]);

        try {
            $rate = json_decode(file_get_contents('http://data.fixer.io/api/' . $request->dob . '?access_key=' . env('FIXER_API_KEY') . '&base=EUR&symbols=GBP'), true);
            if ($rate['success'] && $rate['historical']) {

                $rates = Rates::where('date', $request->dob)->first();
                if (!$rates) {
                    $rates = new Rates();
                    $rates->date = $request->dob;
                    $rates->currency_base = $rate['base'] . ' -> GBP';
                    $rates->currency_rate = $rate['rates']['GBP'];
                    $rates->save();
                } else {
                    $rates->queries = $rates->queries + 1;
                    $rates->save();
                }
            } else {
                Session::flash('error', 'API Error: ' . $rate['error']['type']);
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Session::flash('error', 'API Error or Connection');
            return redirect()->back();
        }

        return redirect()->to('/');
    }

}
