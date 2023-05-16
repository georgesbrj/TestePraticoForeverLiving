<?php

namespace App\Http\Controllers;


use App\Http\Requests\CustomerRequest;
use App\Http\Requests\ImportRequest;
use App\Import\CustomerImport;
use App\Models\Customer;
use App\Report\CustomerReport;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\ViaCep;

class CustomerController extends Controller
{
    protected $customer;
    protected $customer_import;
    protected $customer_report;

    public function __construct(Customer $customer, CustomerImport $customer_import, CustomerReport $customer_report)
    {
        $this->customer = $customer;
        $this->customer_import = $customer_import;
        $this->customer_report = $customer_report;
    }

    public function index()
    {
        $customers =  $this->customer->all();

        return view('customer.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(CustomerRequest $request)
    {
        try {
            $this->customers->create($request->all());
            $notification = array(
                'title' => trans('validation.generic.Success'),
                'message' => trans('validation.generic.created'),
                'alert-type' => 'success'
            );
            return redirect()->route('customers.index')->with($notification);
        } catch (\Exception $e) {
            $notification = array(
                'title' => trans('validation.generic.Error'),
                'message' => trans('validation.generic.not_created') . ': ' . $e->getMessage(),
                'alert-type' => 'danger'
            );
            return back()->with($notification)->withInput();
        }
    }

    public function import()
    {
        return view('customer.import');
    }

    public function storeImport(ImportRequest $request)
    {

        try {
            $notification = $this->customer_import->allData($request);

            $notification = array(
                'title' => trans('validation.generic.Success'),
                'message' => trans('validation.generic.imported') . " " .
                    trans('validation.generic.data_created') . " : " . $notification['created'] . ". " .
                    trans('validation.generic.data_updated') . " : " . $notification['updated'],
                'alert-type' => 'success'
            );

            if ($notification['message'] == "worksheet_imported") {
                $notification = array(
                    'title' => trans('validation.generic.Success'),
                    'message' => trans('validation.generic.imported') . " " .
                        trans('validation.generic.data_created') . " : " . $notification['created'] . ". " .
                        trans('validation.generic.data_updated') . " : " . $notification['updated'],
                    'alert-type' => 'success'
                );
            }


            if ($notification['message']  == "worksheet_invalid") {
                $notification = array(
                    'title' => trans('validation.generic.Error'),
                    'message' => trans('platform.customer.message.import'),
                    'alert-type' => 'danger'
                );
                return back()->withInput()->with($notification);
            }

            return redirect()->route('customers.index')->with($notification);
        } catch (\Exception $e) {
            $notification = array(
                'title' => trans('validation.generic.Error'),
                'message' => trans('validation.generic.not_imported') . ': ' . $e->getMessage(),
                'alert-type' => 'danger'
            );
            return back()->with($notification)->withInput();
        }
    }

    public function report($customers = null)
    {
             
        $customers = $this->customer->all();
              
        try {
            $notification = $this->customer_report->list($customers);
        } catch (\Exception $e) {
            $notification = array(
                'title' => trans('platform.generic.Error'),
                'message' => trans('platform.report.message.generated_error') . ': ' . $e->getMessage(),
                'alert-type' => 'danger'
            );
        }
        
        return view('customer.report',compact('customers'));
    }

    
}
