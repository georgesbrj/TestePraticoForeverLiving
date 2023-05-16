<?php

namespace App\Import;

use App\Http\Controllers\ViaCep;
use App\Models\Customer;
use App\Tools\Sanitize;
use Exception;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CustomerImport
{
    protected $customer;
    protected $sanatize;

    public function __construct(Customer $customer, Sanitize $sanatize)
    {
        $this->customer = $customer;
        $this->sanatize = $sanatize;
    }

    public function allData(Request $request)
    {
     
        //insert customers in the database
        $read = IOFactory::load($request->file);
        $data = $read->getActiveSheet()->toArray();
        $line=0;
        $created=0;
        $updated=0;

        foreach($data as $item){
         
            //condition to verify if has 3 collumns in the worksheet
            if(count($item) >= 3){
                //your condition here to first line
                if($line==0){
                    //
                }
                if($line>0){
                    //verify if the current customer exists
                    $cep = $this->sanatize->validCep($item[2]);
                    $customer = $this->customer->where('cep',$cep)->first();
                    
                    $consulta = ViaCep::consultarCep($item[2]);
                
                    //if exists customer
                    if(!empty($customer)){
                        $customer->update([
                            'codigo'=> $item[0],
                            'fantasia'=> $item[1],
                             'cep'=> $item[2],
                        ]);
                        $updated++;
                    //if not exists
                    }else{
                        $this->customer->create([
                            'codigo'=> $item[0],
                            'fantasia'=> $item[1],
                            'cep'=> $item[2], 
                            'cidade'=> $consulta["localidade"],
                            'logradouro'=> $consulta["logradouro"],
                            'bairro'=> $consulta["bairro"],
                            'uf'=> $consulta["uf"]                                
                        ]);
                        $created++;
                    }
                }
                $line++;
            //not exists 3 columns in the worksheet
            }else{
                throw new Exception(trans('platform.customer.message.import'));
            }
        }
        //returns imported worksheet notification
        $notification = [
            'message'=> "worksheet_imported",
            'created'=> $created,
            'updated'=> $updated
        ];
        return $notification;
    }

     
}
