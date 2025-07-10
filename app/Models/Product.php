<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $fillable = [
        'model_name',
        'line',
        'type',
        'category_id',
        'body_weight',
        'operating_weight',
        'overall_length',
        'overall_width',
        'overall_height',
        'required_oil_flow',
        'operating_pressure',
        'impact_rate',
        'impact_rate_soft_rock',
        'hose_diameter',
        'rod_diameter',
        'applicable_carrier',
        'image_url',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // Media collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);

        $this->addMediaCollection('documents')
            ->acceptsMimeTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->performOnCollections('images');

        $this->addMediaConversion('large')
            ->width(1200)
            ->height(800)
            ->performOnCollections('images');
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function soldProducts()
    {
        return $this->hasMany(SoldProduct::class);
    }    // Helper methods for unit conversion
    public function getSpecificationsWithUnit($unit = 'si')
    {
        $specs = [
            'body_weight' => [
                'value' => $this->body_weight,
                'unit' => 'kg',
                'label' => 'Body Weight'
            ],
            'operating_weight' => [
                'value' => $this->operating_weight,
                'unit' => 'kg',
                'label' => 'Operating Weight'
            ],
            'overall_length' => [
                'value' => $this->overall_length,
                'unit' => 'mm',
                'label' => 'Overall Length'
            ],
            'overall_width' => [
                'value' => $this->overall_width,
                'unit' => 'mm',
                'label' => 'Overall Width'
            ],
            'overall_height' => [
                'value' => $this->overall_height,
                'unit' => 'mm',
                'label' => 'Overall Height'
            ],
            'required_oil_flow' => [
                'value' => $this->required_oil_flow,
                'unit' => 'l/min',
                'label' => 'Required Oil Flow'
            ],
            'operating_pressure' => [
                'value' => $this->operating_pressure,
                'unit' => 'kgf/cm²',
                'label' => 'Operating Pressure'
            ],
            'impact_rate_std' => [
                'value' => $this->impact_rate_std,
                'unit' => 'BPM',
                'label' => 'Impact Rate (STD Mode)'
            ],
            'impact_rate_soft_rock' => [
                'value' => $this->impact_rate_soft_rock,
                'unit' => 'BPM',
                'label' => 'Impact Rate (Soft Rock)'
            ],
            'hose_diameter' => [
                'value' => $this->hose_diameter,
                'unit' => 'in',
                'label' => 'Hose Diameter'
            ],
            'rod_diameter' => [
                'value' => $this->rod_diameter,
                'unit' => 'mm',
                'label' => 'Rod Diameter'
            ],
            'applicable_carrier' => [
                'value' => $this->applicable_carrier,
                'unit' => 'ton',
                'label' => 'Applicable Carrier'
            ],
        ];

        if ($unit === 'imperial') {
            return $this->convertSpecsToImperial($specs);
        }

        return $specs;
    }

    private function convertSpecsToImperial($specs)
    {
        $converted = [];

        foreach ($specs as $key => $spec) {
            $converted[$key] = $this->convertSingleSpecToImperial($spec);
        }

        return $converted;
    }

    private function convertSingleSpecToImperial($spec)
    {
        if (!$spec['value']) {
            return $spec;
        }

        $value = $spec['value'];
        $siUnit = $spec['unit'];

        // Don't convert BPM and inches (already in imperial or universal)
        if (in_array($siUnit, ['BPM', 'in'])) {
            return $spec;
        }

        // Handle range values (e.g., "20 ~ 40")
        if (is_string($value) && str_contains($value, '~')) {
            $parts = explode('~', $value);
            $min = trim($parts[0]);
            $max = trim($parts[1]);

            if (is_numeric($min) && is_numeric($max)) {
                $convertedMin = $this->convertValue($min, $siUnit);
                $convertedMax = $this->convertValue($max, $siUnit);
                return [
                    'value' => $convertedMin['value'] . ' ~ ' . $convertedMax['value'],
                    'unit' => $convertedMin['unit'],
                    'label' => $spec['label']
                ];
            }
        }

        // Handle single numeric values
        if (is_numeric($value)) {
            $converted = $this->convertValue($value, $siUnit);
            return [
                'value' => $converted['value'],
                'unit' => $converted['unit'],
                'label' => $spec['label']
            ];
        }

        return $spec;
    }

    private function convertValue($value, $siUnit)
    {
        $conversions = [
            'kg' => ['factor' => 2.20462, 'unit' => 'lb'],
            'mm' => ['factor' => 0.0393701, 'unit' => 'in'],
            'l/min' => ['factor' => 0.264172, 'unit' => 'gal/min'],
            'kgf/cm²' => ['factor' => 14.2233, 'unit' => 'psi'],
            'ton' => ['factor' => 2204.62, 'unit' => 'lb'],
        ];

        if (isset($conversions[$siUnit])) {
            $converted = $value * $conversions[$siUnit]['factor'];
            return [
                'value' => number_format($converted, $this->getDecimalPlaces($siUnit)),
                'unit' => $conversions[$siUnit]['unit']
            ];
        }

        return ['value' => $value, 'unit' => $siUnit];
    }

    private function getDecimalPlaces($unit)
    {
        $decimals = [
            'kg' => 0,
            'mm' => 1,
            'l/min' => 1,
            'kgf/cm²' => 0,
            'ton' => 0,
        ];

        return $decimals[$unit] ?? 2;
    }
}
