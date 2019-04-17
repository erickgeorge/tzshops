@extends('layouts.master')

@section('title')
    manage departments
    @endSection

@section('body')
    <br>
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

    {{-- tabs --}}
    <div class="payment-section-margin">
        <div class="tab">
            <div class="container-fluid">
                <div class="tab-group row">
                    <button class="tablinks col-md-4" onclick="openTab(event, 'customer')">DIRECTORATES</button>
                    <button class="tablinks col-md-4" onclick="openTab(event, 'delivery')" id="defaultOpen">DEPARTMENTS</button>
                    <button class="tablinks col-md-4" onclick="openTab(event, 'payment')">SECTIONS
                    </button>
                </div>
            </div>

            {{-- directorate tab--}}
            <form method="POST" action="" class="col-md-6">
                @csrf
                <div id="customer" class="tabcontent">
                    <div class="form-group ">
                        <label for="dir_name">Directorate name</label>
                        <input style="color: black" type="text" required class="form-control" id="dir_name"
                               name="dir_name" placeholder="Enter Directorate name">
                    </div>
                    <div class="form-group ">
                        <label for="dir_abb">Directorate abbreviation</label>
                        <input style="color: black" type="text" required class="form-control" id="dir_abb"
                               name="dir_abb" placeholder="Enter Directorate abbreviation">
                    </div>
                    <button style="background-color: green; color: white" type="submit" class="btn btn-success">Save directorate</button>
                </div>
            </form>
            {{-- end inspection --}}

            {{-- department tab --}}
            <form method="POST" action="" class="col-md-6">
                @csrf
                <div id="delivery" class="tabcontent">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="directorate">Directorate/College</label>
                        </div>
                        <select class="custom-select" name="college" id="directorate" onchange="getDepartments()">
                            <option value="">Choose...</option>
                            @foreach($directorates as $directorate)
                                <option value="{{ $directorate->id }}">{{ $directorate->directorate_description }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="dep_name">Department name</label>
                        <input style="color: black" type="text" required class="form-control" id="dep_name" aria-describedby="emailHelp"
                               name="dep_name" placeholder="Enter department name">
                    </div>
                    <div class="form-group ">
                        <label for="dep_ab">Directorate abbreviation</label>
                        <input style="color: black" type="text" required maxlength="8" class="form-control" id="dep_ab" aria-describedby="emailHelp"
                               name="dep_ab" placeholder="Enter department abbreviation">
                    </div>
                    <p style="color: red">You must select a directorate/college to which you are adding a department</p>
                    <button style="background-color: green; color: white" type="submit" class="btn btn-success">Save department</button>
                </div>
            </form>

            {{-- section tab --}}
            <form method="POST" action="" class="col-md-6">
                @csrf
                <div id="payment" class="tabcontent">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="directorate">Directorate/College</label>
                        </div>
                        <select class="custom-select" name="college" id="directorate" onchange="getDepartments()">
                            <option value="">Choose...</option>
                            @foreach($directorates as $directorate)
                                <option value="{{ $directorate->id }}">{{ $directorate->directorate_description }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="directorate">Department</label>
                        </div>
                        <select class="custom-select" name="department" id="department" onchange="getSections()">
                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="sec_name">Section name</label>
                        <input style="color: black" type="text" required class="form-control" id="sec_name" name="sec_name" placeholder="Enter section name">
                    </div>
                    <div class="form-group ">
                        <label for="sec_ab">Section abbreviation</label>
                        <input style="color: black" type="text" required maxlength="8" class="form-control" id="sec_ab"
                               name="sec_ab" placeholder="Enter section abbreviation">
                    </div>
                    <p style="color: red">You must select a department to which you are adding a section</p>
                    <button style="background-color: green; color: white" type="submit" class="btn btn-success">Save section</button>
                </div>
            </form>
        </div>
    </div>
    @endSection