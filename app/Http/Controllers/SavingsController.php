<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Saving;
use App\Models\SavingAmount; 
use Illuminate\Support\Facades\Auth;

class SavingsController extends Controller
{
    public function index()
    {
        // Fetch savings for the authenticated user with 'amounts' relationship
        $savings = Auth::user()->savings()->with('amounts')->get();
        return view('savings.index', compact('savings'));
    }
    
    public function create()
    {
        return view('savings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'desired_amount' => 'required|numeric',
            'desired_date' => 'required|date',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,txt,zip|max:5120', // 5MB limit
        ]);
    
        $data = $request->all();
    
        if ($request->hasFile('attachment')) {
            // Use Laravel's storage method
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }
    
        // Create a new saving attached to the authenticated user
        $saving = Auth::user()->savings()->create($data);
    
        return redirect()->route('savings.index')->with('success', 'Saving created successfully.');
    }
    
    

    public function show(Saving $saving)
    {
        // Check if the saving belongs to the authenticated user
        $this->authorize('view', $saving);
        
        $totalSaved = $saving->amounts()->sum('amount'); // Calculate total saved
        $remainingAmount = $saving->desired_amount - $totalSaved; // Calculate remaining amount
        
        return view('savings.show', compact('saving', 'totalSaved', 'remainingAmount'));
    }

    public function addAmount(Request $request, Saving $saving)
    {
        // Ensure the saving belongs to the logged-in user
        $this->authorize('update', $saving);

        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        // Create a new saving amount record
        SavingAmount::create([
            'user_id' => Auth::id(), // Associate the amount with the logged-in user
            'saving_id' => $saving->id,
            'amount' => $request->amount,
        ]);

        return redirect()->route('savings.show', $saving->id)->with('success', 'Amount added successfully.');
    }

    public function edit(Saving $saving)
    {
        $this->authorize('update', $saving);
        return view('savings.edit', compact('saving'));
    }

    public function update(Request $request, Saving $saving)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'desired_amount' => 'required|numeric',
        'desired_date' => 'required|date',
        'notes' => 'nullable|string',
        'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,txt,zip|max:5120', // 5MB limit
        'remove_attachment' => 'nullable|boolean',
    ]);

    $data = $request->all();

    // Handle attachment removal
    if ($request->has('remove_attachment') && $request->remove_attachment) {
        if ($saving->attachment) {
            Storage::disk('public')->delete($saving->attachment);
            $data['attachment'] = null;
        }
    }

    // Handle new attachment upload
    if ($request->hasFile('attachment')) {
        // Delete old attachment if it exists
        if ($saving->attachment) {
            Storage::disk('public')->delete($saving->attachment);
        }
        // Store the new attachment
        $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
    }

    $saving->update($data);

    return redirect()->route('savings.index')->with('success', 'Saving updated successfully.');
}


    public function destroy(Saving $saving)
    {
        $this->authorize('delete', $saving);
        if ($saving->attachment) {
            unlink(public_path('attachments') . '/' . $saving->attachment);
        }
        $saving->delete();
        return redirect()->route('savings.index')->with('success', 'Saving deleted successfully.');
    }
}
