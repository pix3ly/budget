<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Repositories\AttachmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AttachmentController extends Controller
{
    private $attachmentRepository;

    public function __construct(AttachmentRepository $attachmentRepository)
    {
        $this->attachmentRepository = $attachmentRepository;
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_type' => 'required|in:earning,spending',
            'transaction_id' => 'required',
            'file' => 'required|mimes:jpeg,png,pdf'
        ]);

        $fileName = Str::random(20) . '.' . $request->file('file')->extension();
        $filePath = $request->file('file')->storeAs('attachments', $fileName);

        $transactionType = $request->transaction_type;
        $transactionId = $request->transaction_id;

        $this->attachmentRepository->create($transactionType, $transactionId, $filePath);

        return redirect()->route($transactionType . 's.show', [$transactionType => $transactionId]);
    }

    public function download(Request $request, Attachment $attachment)
    {
        $user = Auth::user();

        if (!$user->spaces->contains($attachment->transaction->space_id)) {
            abort(403);
        }

        if ($attachment->file_type !== 'pdf') {
            return null;
        }

        return response()->download(storage_path() . '/app/' . $attachment->file_path);
    }

    public function delete(Request $request, string $id)
    {
        $attachment = $this->attachmentRepository->getById($id);

        if (!$attachment) {
            abort(404);
        }

        // Memorize some details before we delete it
        $transactionType = $attachment->transaction_type;
        $transactionId = $attachment->transaction_id;

        $this->attachmentRepository->delete($id);

        return redirect()->route($transactionType . 's.show', [$transactionType => $transactionId]);
    }
}
