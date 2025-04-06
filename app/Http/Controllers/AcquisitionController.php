<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcquisitionStoreRequest;
use App\Models\Acquisition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AcquisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search') ?? [];

        $acquisitions = Acquisition::with('audits')->search($search)->get();

        return response()->json([
            'meta' => [ 
                'success' => true, 
                'errors' => []
            ],
            "data" => $acquisitions
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $errors = $this->validator($request->all());
            if (count($errors) > 0) {
                return response()->json([
                    'meta' => [ 
                        'success' => false, 
                        'errors' => $errors
                    ]
                ], 200);
            }

            $acquisition = new Acquisition();
            $fields = $request->only($acquisition->getFillable());
            $acquisition->fill($fields);
            $acquisition->save();
            
            return response()->json([
                'meta' => [ 
                    'success' => true, 
                    'errors' => []
                ],
                "data" => $acquisition->fresh()
            ], 201);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'meta' => [ 
                    'success' => false, 
                    'errors' => [$ex->getMessage()]
                ]
            ], $ex->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Acquisition $acquisition)
    {
        return response()->json($acquisition);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Acquisition $acquisition)
    {
        try {
            $errors = $this->validator($request->all());
            if (count($errors) > 0) {
                return response()->json([
                    'meta' => [ 
                        'success' => false, 
                        'errors' => $errors
                    ]
                ], 422);
            }

            $fields = $request->only($acquisition->getFillable());
            $acquisition->update($fields);

            return response()->json([
                'meta' => [ 
                    'success' => true, 
                    'errors' => []
                ],
                "data" => $acquisition->fresh()
            ], 200);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'meta' => [ 
                    'success' => false, 
                    'errors' => [$ex->getMessage()]
                ]
            ], $ex->getCode());
        }
    }

    /**
     * Change Status the specified resource.
     */
    public function changeStatus(Request $request, Acquisition $acquisition)
    {
        try {
            $status = $request->get('status');
            if ($status != "0" && $status != "1") {
                return response()->json([
                    'meta' => [ 
                        'success' => false, 
                        'errors' => [
                            'status' => ['Error al intentar cambiar']
                        ]
                    ]
                ], 200);
            }

            $acquisition->update(['status' => $status]);

            return response()->json([
                'meta' => [ 
                    'success' => true, 
                    'errors' => []
                ],
                "data" => $acquisition->fresh()
            ], 200);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'meta' => [ 
                    'success' => false, 
                    'errors' => [$ex->getMessage()]
                ]
            ], $ex->getCode());
        }
    }

    /**
     * Validator request.
     *
     * @param  array  $data
     * @return array ErrorsMessages
     */
    private function validator(array $data)
    {
        $validateRequest = new AcquisitionStoreRequest();
        $validator = Validator::make($data, $validateRequest->rules(), $validateRequest->messages());

        return $validator->errors()->messages();
    }

    public function getSuppliers() {
        $acquisitions = DB::table('acquisitions')->select('supplier')->groupBy('supplier')->get();
        
        return response()->json($acquisitions);
    }
}
