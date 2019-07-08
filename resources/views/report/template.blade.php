{{--@extends('layouts.app')

@section('content')--}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $data['title'] }}</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-center">Pastoral Services</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data['report_data'] as $dataItem)
                                <tr>
                                    {{--<th>{{$dataItem['title']}}</th>--}}
                                    <th class="text-center">Total</th>
                                </tr>
                                @foreach($dataItem['records'] as $record)
                                    <tr>
                                        {{--<td>{{ $record['name'] }}</td>--}}
                                        <td class="text-center">{{ $record['recs'] }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    <p class="float-right">Submitted By {{$data['user']->name}}({{$data['user']->email}})</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--
@endsection--}}
