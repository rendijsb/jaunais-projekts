<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Property;
use Illuminate\Support\Collection;

class PropertyRepository
{
    public function __construct(
        private readonly Property $property
    ) {
    }

    public function getFilteredProperties(
        ?string $status = null,
        ?int $floor = null,
        string $sortBy = Property::FLAT_NUMBER,
        string $sortDirection = 'asc'
    ): Collection {
        $query = $this->property->newQuery();

        if ($status !== null) {
            $query->where(Property::STATUS, $status);
        }

        if ($floor !== null) {
            $query->where(Property::FLOOR, $floor);
        }

        if (in_array($sortBy, Property::SORTABLE_COLUMNS, true)) {
            $query->orderBy($sortBy, $sortDirection === 'desc' ? 'desc' : 'asc');
        } else {
            $query->orderBy(Property::FLAT_NUMBER, 'asc');
        }

        return $query->get();
    }

    public function getAvailableFloors(): array
    {
        return $this->property
            ->newQuery()
            ->distinct()
            ->orderBy(Property::FLOOR)
            ->pluck(Property::FLOOR)
            ->toArray();
    }

    public function getStatusCounts(): array
    {
        return $this->property
            ->newQuery()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy(Property::STATUS)
            ->pluck('count', 'status')
            ->toArray();
    }

    public function findById(int $id): ?Property
    {
        return $this->property->find($id);
    }

    public function update(Property $property, array $data): Property
    {
        $property->update($data);
        return $property->fresh();
    }

    public function updateStatus(Property $property, string $status): Property
    {
        $property->update([Property::STATUS => $status]);
        return $property->fresh();
    }
}
