<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\PropertyStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Services\Admin\PropertyRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PropertyController extends Controller
{
    public function __construct(
        private readonly PropertyRepository $propertyRepository
    ) {
    }

    public function getAll(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['nullable', 'string', Rule::enum(PropertyStatusEnum::class)],
            'floor' => ['nullable', 'integer'],
            'sort_by' => ['nullable', 'string', Rule::in(Property::SORTABLE_COLUMNS)],
            'sort_direction' => ['nullable', 'string', Rule::in(['asc', 'desc'])],
        ]);

        $properties = $this->propertyRepository->getFilteredProperties(
            status: $validated['status'] ?? null,
            floor: isset($validated['floor']) ? (int) $validated['floor'] : null,
            sortBy: $validated['sort_by'] ?? Property::FLAT_NUMBER,
            sortDirection: $validated['sort_direction'] ?? 'asc'
        );

        $floors = $this->propertyRepository->getAvailableFloors();
        $statusCounts = $this->propertyRepository->getStatusCounts();

        return response()->json([
            'properties' => $properties,
            'floors' => $floors,
            'status_counts' => [
                'available' => $statusCounts['available'] ?? 0,
                'reserved' => $statusCounts['reserved'] ?? 0,
                'sold' => $statusCounts['sold'] ?? 0,
            ],
            'total' => $properties->count(),
        ]);
    }

    public function update(Request $request, Property $property): JsonResponse
    {
        $validated = $request->validate([
            'flat_number' => ['required', 'integer'],
            'floor' => ['required', 'integer'],
            'flat_area' => ['required', 'numeric', 'min:0'],
            'total_area' => ['required', 'numeric', 'min:0'],
            'terrace_area' => ['nullable', 'numeric', 'min:0'],
            'balcony_area' => ['nullable', 'numeric', 'min:0'],
            'price' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', Rule::enum(PropertyStatusEnum::class)],
        ]);

        $updatedProperty = $this->propertyRepository->update($property, $validated);

        return response()->json($updatedProperty);
    }

    public function updateStatus(Request $request, Property $property): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::enum(PropertyStatusEnum::class)],
        ]);

        $updatedProperty = $this->propertyRepository->updateStatus(
            $property,
            $validated['status']
        );

        return response()->json($updatedProperty);
    }
}
