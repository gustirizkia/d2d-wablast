<?php

namespace App\Http\Controllers\Admin\Wa;

use App\Http\Controllers\Controller;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $client = new Client();
            $response = $client->get(env("WA_API")."device/info?token=".env("WA_TOKEN"), [
                "verify" => false,
            ]);
            $response = json_decode($response->getBody()->getContents());

            return view("pages.wa.device.index", [
                'item' => $response->data
            ]);
        } catch (Exception $th) {
            return abort(500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       try {
            $client = new Client();
            $response = $client->post(env("WA_API")."device/change-number", [
                "verify" => false,
                "headers" => [
                    "Authorization" => env("WA_TOKEN")
                ],
                "form_params" => [
                    "phone" => $request->number
                ],
            ]);
            $response = json_decode($response->getBody()->getContents());

            return redirect()->back()->with("success", "Berhasil update nomor");
        } catch (Exception $th) {
            dd($th->getMessage());
            return abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
