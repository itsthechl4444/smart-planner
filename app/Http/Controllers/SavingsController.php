<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saving;
use App\Models\SavingAmount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SavingsController extends Controller
{
    public function index()
    {
        // Fetch savings for the authenticated user along with their amounts
        $savings = Auth::user()->savings()->with('amounts')->get();
        return view('financemanagement.index', compact('savings'));
    }

    public function create()
    {
        return view('savings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'desired_amount' => 'required|numeric',
            'desired_date'   => 'required|date',
            'notes'          => 'nullable|string',
            'attachment'     => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,txt,zip|max:5120',
        ]);

        $data = $request->all();

        if ($request->hasFile('attachment')) {
            // Store the attachment and add its path to the data array
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        // Create a new saving associated with the authenticated user
        $saving = Auth::user()->savings()->create($data);

        return redirect(route('financemanagement.index') . '#savings')
            ->with('success', 'Saving created successfully.');
    }

    public function show(Saving $saving)
    {
        // Ensure the saving belongs to the authenticated user
        $this->authorize('view', $saving);

        // Calculate totals (these are also available via the accessors)
        $totalSaved    = (float) $saving->amounts()->sum('amount');
        $desiredAmount = (float) $saving->desired_amount;
        $remainingAmount = $desiredAmount - $totalSaved;

        return view('savings.show', compact('saving', 'totalSaved', 'remainingAmount'));
    }

    public function edit(Saving $saving)
    {
        $this->authorize('update', $saving);
        return view('savings.edit', compact('saving'));
    }

    public function update(Request $request, Saving $saving)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'desired_amount' => 'required|numeric',
            'desired_date'   => 'required|date',
            'notes'          => 'nullable|string',
            'attachment'     => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,txt,zip|max:5120',
            'remove_attachment' => 'nullable|boolean',
        ]);

        $data = $request->all();

        // Handle attachment removal if requested
        if ($request->has('remove_attachment') && $request->remove_attachment) {
            if ($saving->attachment) {
                Storage::disk('public')->delete($saving->attachment);
                $data['attachment'] = null;
            }
        }

        // Handle new attachment upload if provided
        if ($request->hasFile('attachment')) {
            if ($saving->attachment) {
                Storage::disk('public')->delete($saving->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $saving->update($data);

        return redirect(route('financemanagement.index') . '#savings')
            ->with('success', 'Saving updated successfully.');
    }

    public function destroy(Saving $saving)
    {
        $this->authorize('delete', $saving);
        if ($saving->attachment) {
            Storage::disk('public')->delete($saving->attachment);
        }
        $saving->delete();

        return redirect(route('financemanagement.index') . '#savings')
            ->with('success', 'Saving deleted successfully.');
    }

    // New method to add an amount to a saving
    public function addAmount(Request $request, Saving $saving)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        // Create a new SavingAmount associated with this saving and the current user
        $saving->amounts()->create([
            'user_id'   => Auth::id(),
            'amount'    => $request->amount,
        ]);

        return redirect()->back()->with('success', 'Amount saved successfully.');
    }
}
