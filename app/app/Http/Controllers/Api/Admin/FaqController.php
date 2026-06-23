<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\DTOs\FaqDTO;
use App\Services\Interfaces\FaqServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FaqController extends Controller
{
    protected $faqService;

    public function __construct(FaqServiceInterface $faqService)
    {
        $this->faqService = $faqService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'is_active']);
        $perPage = $request->input('per_page', 20);

        $faqs = $this->faqService->getFaqs($filters, $perPage);
        return response()->json($faqs);
    }

    public function show($id)
    {
        try {
            $faq = $this->faqService->getFaq($id);
            return response()->json($faq);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Không tìm thấy câu hỏi'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'question' => 'required|string',
                'answer' => 'nullable|string',
                'sort_order' => 'nullable|integer',
                'is_active' => 'boolean',
            ]);

            $dto = new FaqDTO($validated);
            $faq = $this->faqService->createFaq($dto);

            return response()->json($faq, 201);
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
                'question' => 'required|string',
                'answer' => 'nullable|string',
                'sort_order' => 'nullable|integer',
                'is_active' => 'boolean',
            ]);

            $dto = new FaqDTO($validated);
            $faq = $this->faqService->updateFaq($id, $dto);

            return response()->json($faq);
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
            $this->faqService->deleteFaq($id);
            return response()->json(['message' => 'Xóa câu hỏi thành công']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}