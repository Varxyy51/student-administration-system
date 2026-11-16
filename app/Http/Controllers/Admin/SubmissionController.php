<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\SubmissionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $submissions = Submission::with(['user.studentProfile', 'letterType', 'documents'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->get();

        $stats = [
            'total' => Submission::count(),
            'pending' => Submission::where('status', 'pending')->count(),
            'approved' => Submission::where('status', 'approved')->count(),
            'rejected' => Submission::where('status', 'rejected')->count(),
        ];

        return view('admin.dashboard', compact('submissions', 'stats', 'status'));
    }

    public function show(Submission $submission)
    {
        $submission->load(['user.studentProfile', 'letterType', 'documents', 'histories.actor', 'reviewer']);

        return view('admin.submissions.show', compact('submission'));
    }

    public function updateStatus(Request $request, Submission $submission)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'admin_note' => ['required_if:status,rejected', 'nullable', 'string', 'max:1000'],
        ], [
            'admin_note.required_if' => 'Alasan penolakan wajib diisi jika pengajuan ditolak.',
        ]);

        DB::transaction(function () use ($validated, $submission) {
            $submission->update([
                'status' => $validated['status'],
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
                'admin_note' => $validated['admin_note'],
            ]);

            $defaultNote = $validated['status'] === 'approved'
                ? 'Pengajuan surat diverifikasi dan disetujui oleh Admin.'
                : 'Pengajuan surat ditolak: ' . $validated['admin_note'];

            SubmissionHistory::create([
                'submission_id' => $submission->id,
                'actor_id' => Auth::id(),
                'status' => $validated['status'],
                'note' => $validated['admin_note'] ?: $defaultNote,
            ]);
        });

        return redirect()->route('admin.submissions.show', $submission)
            ->with('success', 'Status pengajuan berhasil diperbarui menjadi ' . strtoupper($validated['status']) . '.');
    }

    public function print(Submission $submission)
    {
        if ($submission->status !== 'approved') {
            abort(403, 'Surat hanya dapat dicetak jika status sudah disetujui.');
        }

        $submission->load(['user.studentProfile', 'letterType', 'reviewer']);

        return view('letters.print', compact('submission'));
    }
}