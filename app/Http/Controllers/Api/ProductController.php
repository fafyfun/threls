<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    //

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        ini_set('max_execution_time', '3000');

        /**
         * Import Product Data To Database
         * @param Request request
         * @return Success
         */

        try {
            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:csv'
            ]);
            if ($validator->fails()) {

                return response()->json(['error' => $validator->errors()], 401);
            }
            Excel::import(new ProductImport(), $request->file('file'));
            return response()->json([
                'status' => true,
                'message' => "Products Updated",

            ], 200

            );
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()

            ], 500

            );

        }

    }
}
