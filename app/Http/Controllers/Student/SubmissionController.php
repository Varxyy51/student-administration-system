<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\LetterType;
use App\Models\Submission;
use App\Models\SubmissionDocument;
use App\Models\SubmissionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = Submission::with(['letterType', 'documents'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $letterTypes = LetterType::where('is_active', true)->get();

        return view('student.dashboard', compact('submissions', 'letterTypes'));
    }

    public function create()
    {
        $letterTypes = LetterType::where('is_active', true)->get();

        return view('student.submissions.create', compact('letterTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'letter_type_id' => ['required', 'exists:letter_types,id'],
            'purpose' => ['required', 'string', 'min:10', 'max:1000'],
            'documents' => ['required', 'array', 'min:1'],
            'documents.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ], [
            'documents.required' => 'Minimal upload 1 dokumen persyaratan.',
            'documents.*.mimes' => 'Format file harus PDF, JPG, JPEG, atau PNG.',
            'documents.*.max' => 'Ukuran maksimal tiap file adalah 2MB.',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $submissionNumber = 'REQ-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));

            $submission = Submission::create([
                'submission_number' => $submissionNumber,
                'user_id' => Auth::id(),
                'letter_type_id' => $validated['letter_type_id'],
                'purpose' => $validated['purpose'],
                'status' => 'pending',
            ]);

            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $path = $file->store('submission_documents/' . Auth::id(), 'public');

                    SubmissionDocument::create([
                        'submission_id' => $submission->id,
                        'original_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'mime_type' => $file->getClientMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }

            SubmissionHistory::create([
                'submission_id' => $submission->id,
                'actor_id' => Auth::id(),
                'status' => 'pending',
                'note' => 'Pengajuan surat berhasil dikirim oleh mahasiswa.',
            ]);
        });

        return redirect()->route('student.dashboard')
            ->with('success', 'Pengajuan surat berhasil dikirim! Silakan pantau statusnya secara berkala.');
    }

    public function show(Submission $submission)
    {
        if ($submission->user_id !== Auth::id()) {
            abort(403);
        }

        $submission->load(['letterType', 'documents', 'histories.actor', 'reviewer']);

        return view('student.submissions.show', compact('submission'));
    }
}