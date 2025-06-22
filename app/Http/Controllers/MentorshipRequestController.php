<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MentorshipRequest;

class MentorshipRequestController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'mentor_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
        ]);

        MentorshipRequest::create([
            'student_id' => 1, // hardcoded for now
            'mentor_id' => $request->mentor_id,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Request created!');
    }

    public function incoming()
    {
        $requests = MentorshipRequest::where('mentor_id', 2)->get(); // hardcoded mentor
        return response()->json($requests);
    }

    public function accept($id)
    {
        $request = MentorshipRequest::where('mentor_id', 2)->findOrFail($id);
        $request->update(['status' => 'accepted']);
        return response()->json(['message' => 'Request accepted.']);
    }

    public function reject($id)
    {
        $request = MentorshipRequest::where('mentor_id', 2)->findOrFail($id);
        $request->update(['status' => 'rejected']);
        return response()->json(['message' => 'Request rejected.']);
    }
}
