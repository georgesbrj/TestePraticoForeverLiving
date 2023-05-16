@extends('layouts.app')
@section('title')
    <title>@lang('platform.customer.name')</title>
@endsection
@section('body')
    <br>
    <div class="mb-1 p-3">
        <a href="{{route('customers.index')}}" class="btn btn-dark">@lang('platform.generic.message.index')</a>     
        <a href="{{route('customers.import')}}" class="btn btn-info">@lang('platform.customer.import')</a>
        @if (count($customers)>0)
            <a href="{{route('customers.report')}}" class="btn btn-success">Dowload Relatorio</a>
        @endif
    </div>
    <h3  class="mb-1  p-3">@lang('platform.customer.name')</h3>
    <div class="mb-1  p-5">
        <table  class="table display" id="myTable">
            <thead>
                <tr>                
                <th>Código de cliente</th>
                <th>Codigo identificador</th>
                <th>CEP</th>
                <th>Status CEP</th>
                <th>Cidade</th>
                <th>Logradouro</th>
                <th>UF</th>                            
                </tr>
            </thead>
            <tbody>
                @if(count($customers)==0)
                    <td colspan="5">@lang('platform.customer.message.no_data')</td>
                @else
                    @foreach ($customers as $item)
                        <tr>                        
                            <td>{{$item->codigo}}</td>
                            <td>{{$item->fantasia}}</td>
                            <td>{{$item->cep}}</td> 
                            <td><?php if($item->logradouro) echo "ok" ?></td>
                            <td>{{$item->cidade}}</td> 
                            <td>{{$item->logradouro}}</td>                      
                            <td>{{$item->uf}}</td>                                                    
                        </tr>                
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>