<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Medicamento;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicamentos = Medicamento::select('id', 'descripcion', 'presentacion', 'unidad', 'stock_max')
            ->get();
        return Inertia::render('Medicamentos/Index', ['medicamentos' => $medicamentos]);
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
        $request->validate([
            'descripcion' => 'required|max:90',
            'presentacion' => 'required|max:80',
            'stock_max' => 'required|numeric',
        ]);
        $medicamento = new Medicamento($request->input());
        $medicamento->save();
        return redirect('medicamentos');
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicamento $medicamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicamento $medicamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicamento $medicamento)
    {
        $request->validate([
            'descripcion' => 'required|max:90',
            'presentacion' => 'required|max:80',
            'stock_max' => 'required|numeric',
        ]);
        $medicamentos->update($request->input());
        return redirect('medicamentos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicamento $medicamento)
    {
        $medicamentos->delete();
        return redirect('medicamentos');
    }
}
