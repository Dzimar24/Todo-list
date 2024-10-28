<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $todos = Todo::orderBy('id', 'ASC')->get();
        $titleTable = 'Todo List';
        return view('index', compact('todos', 'titleTable'));
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $cleanDescription = str_replace('&nbsp;', ' ', $request->description);

        try {
            Todo::create([
                'title' => $request->title,
                'description' => $cleanDescription
            ]);

            return redirect()->back()->with('success', 'Todo created successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->withErrors($validated)->withInput()->with('error', $th->getMessage());
        }
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
        //
        $request->validate([
            'title' => 'string',
            'description' => 'string'
        ]);

        try {
            $todo = Todo::findOrFail($id);

            $cleanDescription = str_replace('&nbsp;', ' ', $request->description);

            $todo->update([
                'title' => $request->title,
                'description' => $cleanDescription
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Todo updated successfully',
                'data' => $todo
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $todo = Todo::findOrFail($id);
            $todo->delete();

            return redirect()->back()->with('success', 'Todo deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
