<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialReminder;
use Illuminate\Support\Facades\Auth;

class FinancialReminderController extends Controller
{

    /**
     * Display a listing of financial reminders.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $reminders = FinancialReminder::where('user_id', Auth::id())->get();
        return view('financial_reminders.index', compact('reminders'));
    }
     /**
     * Store a newly created financial reminder in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        try {
            // Create a new financial reminder associated with the authenticated user
            $reminder = Auth::user()->financialReminders()->create([
                'title' => $validated['title'],
                'due_date' => $validated['due_date'],
                'description' => $validated['description'] ?? null,
            ]);

            return response()->json(['message' => 'Financial reminder created successfully.'], 201);
        } catch (\Exception $e) {
            \Log::error('Error creating financial reminder: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create financial reminder.'], 500);
        }
    }

    /**
     * Display the specified financial reminder.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $reminder = FinancialReminder::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

            return response()->json([
                'title' => $reminder->title,
                'due_date' => $reminder->due_date,
                'description' => $reminder->description,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching financial reminder: ' . $e->getMessage());
            return response()->json(['error' => 'Financial reminder not found.'], 404);
        }
    }

    /**
     * Delete the specified financial reminder from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $reminder = FinancialReminder::findOrFail($id);

        // Optional: Add authorization if using policies
        // $this->authorize('delete', $reminder);

        $reminder->delete();

        return response()->json([
            'message' => 'Financial reminder deleted successfully!',
        ]);
    }
}
