<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderTrackingController extends Controller
{
    public function trackOrder(Request $request)
    {

        
        // $request->validate([
        //     'order_id' => 'required|string',
        // ]);

        $bookingId = trim($request->booking_id ?? '');

        // dd($bookingId);

        if (empty($bookingId)) {
            return response()->json([
                'success' => false,
                'message' => 'Booking ID missing',
            ], 400);
        }

        

        // Get Salesforce Access Token
        $accessToken = $this->getSalesforceAccessToken();

        if (!$accessToken) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch Salesforce token',
            ], 500);
        }

        $instanceUrl = 'https://tsl.my.salesforce.com';

        // SOQL Query
        $query = "
            SELECT 
                Booking_Date__c,
                OrderNumber__c,
                Place_PO_Date__c,
                Max_Accepted_by_plant_Date__c,
                Max_Dispatch_Date__c,
                Expected_Delivery_Date__c,
                Revised_CPDD_Date__c,
                Mode_Of_Payment__c,
                Dealer__c,
                Distributor__c,
                Total_Opportunity_Qty_w_o_Accessory__c,
                Max_Manufactured_Date__c,
                Expected_Std_Dispatch_Date__c,
                BM_Booking_Date__c,
                B2B_SO_Creation_Date__c,
                Order_Domain__c
            FROM Opportunity
            WHERE OrderNumber__c = '{$bookingId}'
        ";

        $query = preg_replace('/\s+/', ' ', trim($query));

        $url = $instanceUrl . '/services/data/v51.0/query';

        // Salesforce API Request
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get($url, [
            'q' => $query,
        ]);

        if (!$response->successful()) {
            return response()->json([
                'success' => false,
                'message' => 'Salesforce API request failed',
                'error' => $response->body(),
            ], 500);
        }

        $body = $response->json();

        // if (!empty($body['records'])) {
        //     return response()->json([
        //         'success' => true,
        //         'data' => $body['records'][0],
        //     ]);
        // }

        if (!empty($body['records'])) {

            $record = $body['records'][0];

            if(!empty($record['Order_Domain__c']) && $record['Order_Domain__c']=='B2B'){
                $record['Booking_Date__c'] = $record['BM_Booking_Date__c'];
                $record['Place_PO_Date__c'] = $record['B2B_SO_Creation_Date__c'];

            }else{
                $record['Booking_Date__c'] = $record['Booking_Date__c'];
                $record['Place_PO_Date__c'] = $record['Place_PO_Date__c'];
            }

            
            $record['OrderNumber__c'] = $record['OrderNumber__c'];
            $record['Max_Accepted_by_plant_Date__c'] = $record['Max_Accepted_by_plant_Date__c'];
            $record['Max_Dispatch_Date__c'] = $record['Max_Dispatch_Date__c'];
            $record['Expected_Delivery_Date__c'] = $record['Expected_Delivery_Date__c'];
            $record['Revised_CPDD_Date__c'] = $record['Revised_CPDD_Date__c'];
            $record['Mode_Of_Payment__c'] = $record['Mode_Of_Payment__c'];
            $record['Dealer__c'] = $record['Dealer__c'];
            $record['Distributor__c'] = $record['Distributor__c'];
            $record['Total_Opportunity_Qty_w_o_Accessory__c'] = $record['Total_Opportunity_Qty_w_o_Accessory__c'];
            $record['Max_Manufactured_Date__c'] = $record['Max_Manufactured_Date__c'];
            $record['Expected_Std_Dispatch_Date__c'] = $record['Expected_Std_Dispatch_Date__c'];


            $currentStatus = '';

            if (!empty($record['Expected_Std_Dispatch_Date__c'])) {
                $currentStatus = 'Dispatched (Expected)';
            } elseif (!empty($record['Max_Manufactured_Date__c'])) {
                $currentStatus = 'Manufacturing - In Production';
            } elseif (!empty($record['Max_Accepted_by_plant_Date__c'])) {
                $currentStatus = 'Order Accepted';
            } elseif (!empty($record['Place_PO_Date__c'])) {
                $currentStatus = 'Order Placed';
            } else {
                $currentStatus = 'Order Placed';
            }

            $record['current_status'] = $currentStatus;

            return response()->json([
                'success' => true,
                'data' => $record,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No order found for this Booking ID',
        ], 404);
    }

    private function getSalesforceAccessToken()
    {
        $url = 'https://login.salesforce.com/services/oauth2/token';

        $response = Http::asForm()->post($url, [
            'grant_type'    => 'password',
            'client_id'     => env('SALESFORCE_CLIENT_ID'),
            'client_secret' => env('SALESFORCE_CLIENT_SECRET'),
            'username'      => env('SALESFORCE_USERNAME'),
            'password'      => env('SALESFORCE_PASSWORD'),
        ]);

        if (!$response->successful()) {
            return null;
        }

        $body = $response->json();

        return $body['access_token'] ?? null;
    }

    public function logout(Request $request)
    {
        // dd($request->bearerToken());
        $user = $request->user();
        $user->tokens()->delete();

        LoginHistory::where('user_id', $user->id)
            ->where('token', $request->bearerToken())
            ->update(['logout_time' => now()]);

        return response()->json([
            'status' => 1,
            'msg' => 'Logout successful',
        ]);

    }
}   