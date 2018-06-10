<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>E3 Test</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">E3 Test</h1>
                    <hr/>
                </div>
                <div class="col-md-5">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="title">Parameters</div>
                        </div>
                        {{ Form::open() }}
                        <div class="panel-body">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                {{ $error }}
                                @endforeach
                            </div>
                            @endif
                            @if(Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                            @endif
                            <div class="form-group">
                                {{ Form::label('dob', 'Date of Birth') }}
                                {{ Form::date('dob', old('dob'), ['class' => 'form-control', 'required']) }}
                            </div>
                        </div>
                        <div class="panel-footer">
                            {{ Form::submit('Submit', ['class' => 'btn btn-sm btn-warning']) }}
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
                <div class="col-md-7">
                    <table class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Currency Pair</th>
                                <th class="text-right">Rate</th>
                                <th class="text-right">Queries</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rates as $rate)
                            <tr>
                                <td>{{ date('dS F Y', strtotime($rate->date)) }}</td>
                                <td>{{ $rate->currency_base }}</td>
                                <td class="text-right">{{ $rate->currency_rate }}</td>
                                <td class="text-right">{{ $rate->queries }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
