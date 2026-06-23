<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\DTOs\ContactDTO;
use App\Services\Interfaces\ContactServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactServiceInterface $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'is_read']);
        $perPage = $request->input('per_page', 20);

        $contacts = $this->contactService->getContacts($filters, $perPage);
        return response()->json($contacts);
    }

    public function show($id)
    {
        try {
            $contact = $this->contactService->getContact($id);
            return response()->json($contact);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Không tìm thấy liên hệ'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'fullname' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:20',
                'subject' => 'nullable|string|max:255',
                'message' => 'required|string',
                'is_read' => 'boolean',
            ]);

            $dto = new ContactDTO($validated);
            $contact = $this->contactService->createContact($dto);

            return response()->json($contact, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Lỗi máy chủ: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'fullname' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:20',
                'subject' => 'nullable|string|max:255',
                'message' => 'required|string',
                'is_read' => 'boolean',
            ]);

            $dto = new ContactDTO($validated);
            $contact = $this->contactService->updateContact($id, $dto);

            return response()->json($contact);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Lỗi máy chủ: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->contactService->deleteContact($id);
            return response()->json(['message' => 'Xóa liên hệ thành công']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}