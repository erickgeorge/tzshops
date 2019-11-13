@extends('layouts.master')

@section('title')
    change password
    @endSection

@section('body')
    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center">Change password</h3>
        </div>
    </div>
    <hr>
    @if ($errors->any())
        <div class="alert alert-danger">
             <ul class="alert alert-danger">
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

    <div class="col-lg-12">
        <div align="center">
        <p style="color: red">All fields are compulsory</p>

        <form action="{{ route('password.change') }}" method="POST">
            @csrf

            <div class="form-group col-lg-6">
                <label for="old-pass">Old password <sup style="color: red;">*</sup></label>
                <input type="password" required class="form-control" id="old-pass" name="old-pass"
                       placeholder="Enter old password" value="{{ old('old-pass') }}">
            </div>
            <div class="form-group col-lg-6">
                <label for="new-pass">New password <sup style="color: red;">*</sup></label>
                <input type="password" required class="form-control" id="new-pass" name="new-pass"
                       placeholder="Enter new password" value="{{ old('new-pass') }}">
            </div>
            <div class="form-group col-lg-6">
                <label for="confirm-pass">New password <sup style="color: red;">*</sup></label>
                <input type="password" required class="form-control" id="confirm-pass" name="confirm-pass"
                       placeholder="Confirm password" value="{{ old('confirm-pass') }}">
            </div>
            <button type="submit" class="btn btn-primary">Change password</button>
            <a href="{{ route('home') }}" class="btn btn-danger">Cancel</a>

        </form>
    </div>
    </div>
    @endSection