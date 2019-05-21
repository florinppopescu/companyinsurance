@extends('layouts.master')

@section('content')
    <div class="jumbotron">
        <div class="col-md-12">
            <div class="col-md-4 col-lg-6">
                <form method="POST" action="/">
                    @csrf
                    <div class="form-group">
                        <label for="company_number">Company number</label>
                        <input type="text" class="form-control" name="company_number" placeholder="Enter the first number" value="{{ old('company_number') }}">
                    </div>
                    <div class="form-group">
                        <label for="first_name">First name</label>
                        <input type="text" class="form-control" name="first_name" placeholder="Enter the first name" value="{{ old('first_name') }}">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last name</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Enter the last (family) name" value="{{ old('last_name') }}">
                    </div>

                    <button type="submit" class="btn btn-primary pull-right">Get Insurance NOW!</button>
                </form>
                <hr>
            </div>
            <div class="col-md-4 col-lg-6">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(!$errors->any() && isset($result))
                    <div class="alert alert-success">
                        <ul>
                            {{ $result }}</strong>
                        </ul>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection