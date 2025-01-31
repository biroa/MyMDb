<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Provider/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Provider $provider):void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provider $provider):void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provider $provider):void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provider $provider):void
    {
        //
    }
}
