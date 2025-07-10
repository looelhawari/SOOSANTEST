<?php

namespace App\Http\Controllers;

use App\Models\SoldProduct;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SerialLookupController extends Controller
{
    public function index()
    {
        return view('public.serial-lookup.index');
    }

    public function lookup(Request $request)
    {
        try {
            // Validate the input with more comprehensive rules
            $validated = $request->validate([
                'serial_number' => [
                    'required',
                    'string',
                    'min:3',
                    'max:50',
                    'regex:/^[A-Z0-9\-_]+$/i'  // Allow alphanumeric, hyphens, and underscores
                ],
                'unit' => 'nullable|in:si,imperial',
            ], [
                'serial_number.required' => __('common.please_enter_serial'),
                'serial_number.min' => __('common.serial_min_length'),
                'serial_number.max' => __('common.serial_max_length'),
                'serial_number.regex' => __('common.serial_invalid_format'),
            ]);
            
            $serialNumber = strtoupper(trim($validated['serial_number']));
            $unit = $validated['unit'] ?? 'imperial'; // Default to imperial mode
            
            // Log the lookup attempt
            Log::info('Serial number lookup attempt', [
                'serial_number' => $serialNumber,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            
            // Search for the product with eager loading for better performance
            $soldProduct = SoldProduct::with(['product.category', 'owner'])
                ->where('serial_number', $serialNumber)
                ->first();
            
            $warrantyStatus = null;
            $warrantyEnd = null;
            
            if (!$soldProduct) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', __('common.not_found'));
            }
            
            // Get warranty status for found product
            $warrantyStatus = $this->checkWarrantyStatus($soldProduct);
            $warrantyEnd = $soldProduct->warranty_end_date 
                ? $soldProduct->warranty_end_date->format('F j, Y') 
                : '-';
            
            // Log successful lookup
            Log::info('Serial number lookup successful', [
                'serial_number' => $serialNumber,
                'product_id' => $soldProduct->product_id,
                'warranty_status' => $warrantyStatus,
            ]);
            
            return view('public.serial-lookup.result', [
                'soldProduct' => $soldProduct,
                'warrantyStatus' => $warrantyStatus,
                'warrantyEnd' => $warrantyEnd,
                'unit' => $unit,
                'searchedSerial' => $serialNumber,
            ]);
            
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', __('common.check_input_try_again'));
                
        } catch (\Exception $e) {
            // Log the error
            Log::error('Serial lookup error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', __('common.processing_error'));
        }
    }

    private function checkWarrantyStatus(SoldProduct $soldProduct)
    {
        if (!$soldProduct->warranty_end_date) {
            return [
                'status' => 'unknown',
                'message' => __('common.warranty_not_available'),
                'is_valid' => false
            ];
        }

        $isUnderWarranty = $soldProduct->isUnderWarranty();
        $warrantyEndDate = $soldProduct->warranty_end_date;

        if ($isUnderWarranty) {
            $daysRemaining = now()->diffInDays($warrantyEndDate, false);
            return [
                'status' => 'active',
                'message' => __('common.warranty_valid_days', ['days' => $daysRemaining]),
                'end_date' => $warrantyEndDate->format('M d, Y'),
                'is_valid' => true
            ];
        } else {
            $daysExpired = now()->diffInDays($warrantyEndDate, false);
            return [
                'status' => 'expired',
                'message' => __('common.warranty_expired_days', ['days' => abs($daysExpired)]),
                'end_date' => $warrantyEndDate->format('M d, Y'),
                'is_valid' => false
            ];
        }
    }
}
