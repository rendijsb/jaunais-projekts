export const PropertyStatus = {
    AVAILABLE: 'available',
    RESERVED: 'reserved',
    SOLD: 'sold'
};

export const PropertyStatusLabels = {
    [PropertyStatus.AVAILABLE]: 'Pieejams',
    [PropertyStatus.RESERVED]: 'Rezervēts',
    [PropertyStatus.SOLD]: 'Pārdots'
};

export const PropertyStatusOptions = [
    { value: PropertyStatus.AVAILABLE, label: PropertyStatusLabels[PropertyStatus.AVAILABLE] },
    { value: PropertyStatus.RESERVED, label: PropertyStatusLabels[PropertyStatus.RESERVED] },
    { value: PropertyStatus.SOLD, label: PropertyStatusLabels[PropertyStatus.SOLD] }
];

export const getStatusLabel = (status) => {
    return PropertyStatusLabels[status] || status;
};
