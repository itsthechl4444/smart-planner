<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabelController extends Controller
{
    public function index()
    {
        // Retrieve only the labels belonging to the logged-in user
        $labels = Auth::user()->labels()->get();
        return view('labels.index', compact('labels'));
    }

    /**
     * Display the form to create a new label.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('labels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|max:255',
            'description' => 'nullable',
            'color'       => 'nullable',
        ]);

        // Create the label with the associated user_id
        Auth::user()->labels()->create($request->all());

        // Redirect to the task management index with the labels section active using the URL fragment
        return redirect()->to(route('taskmanagement.index') . '#labels')
            ->with('activeTab', 'labels')
            ->with('success', 'Label created successfully.');
    }

    public function show(Label $label)
    {
        // Ensure the label belongs to the logged-in user
        $this->authorize('view', $label);

        return view('labels.show', compact('label'));
    }

    public function edit(Label $label)
    {
        // Ensure the label belongs to the logged-in user
        $this->authorize('update', $label);

        return view('labels.edit', compact('label'));
    }

    public function update(Request $request, Label $label)
    {
        $request->validate([
            'name'        => 'required|max:255',
            'description' => 'nullable',
            'color'       => 'nullable',
        ]);

        // Ensure the label belongs to the logged-in user
        $this->authorize('update', $label);

        $label->update($request->all());

        // Redirect to the task management index with the labels section active using the URL fragment
        return redirect()->to(route('taskmanagement.index') . '#labels')
            ->with('activeTab', 'labels')
            ->with('success', 'Label updated successfully.');
    }

    public function destroy(Label $label)
    {
        // Ensure the label belongs to the logged-in user
        $this->authorize('delete', $label);

        $label->delete();

        // Redirect to the task management index with the labels section active using the URL fragment
        return redirect()->to(route('taskmanagement.index') . '#labels')
            ->with('activeTab', 'labels')
            ->with('success', 'Label deleted successfully.');
    }
}
