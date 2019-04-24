@extends('layouts.master')

@section('title')
    change password
    @endSection

@section('body')
    <br>
    <div class="row container-fluid">
        <div class="col-md-8">
            <h3>Change password</h3>
        </div>
    </div>
    <hr>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif

    <div class="col-md-6">
        <p style="color: red">All fields are compulsory</p>

        <form action="{{ route('password.change') }}" method="POST">
            @csrf
            <div class="form-group ">
                <label for="old-pass">Old password</label>
                <input type="password" required class="form-control" id="old-pass" name="old-pass"
                       placeholder="Enter old password" value="{{ old('old-pass') }}">
            </div>
            <div class="form-group ">
                <label for="new-pass">New password</label>
                <input type="password" required class="form-control" id="new-pass" name="new-pass"
                       placeholder="Enter new password" value="{{ old('new-pass') }}">
            </div>
            <div class="form-group ">
                <label for="confirm-pass">New password</label>
                <input type="password" required class="form-control" id="confirm-pass" name="confirm-pass"
                       placeholder="Confirm password" value="{{ old('confirm-pass') }}">
            </div>
            <button type="submit" style="background-color:#2E77BB;border-color:#2E77BB;" class="btn btn-success">Change password</button>
            <a href="{{ route('home') }}" style="background-color:#F9B100;border-color:#F9B100;" class="btn btn-danger">Cancel</a>
        </form>
    </div>
    @endSection