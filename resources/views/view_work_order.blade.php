@extends('layouts.master')

@section('title')
    work order
    @endSection

@section('body')
    <br>
    <div class="row container-fluid">
        <div class="col-md-8">
            <h3>Work order details</h3>
        </div>
    </div>
    <hr>
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
    <h5>This work order is from <span style="color: green">{{ $wo['user']->fname.' '.$wo['user']->lname }}</span></h5>
    <h5>Has been submitted on <span style="color: green">{{ date('F d Y', strtotime($wo->created_at)) }}</span></h5>
    <h3 style="color: black">Contacts:</h3>
    <h5>{{ $wo['user']->phone }}</h5>
    <h5>{{ $wo['user']->email }}</h5>
    <br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Type of a problem</label>
        </div>
        <input type="text" required class="form-control" placeholder="problem" name="problem"
               aria-describedby="emailHelp" value="{{ $wo->problem_type }}" disabled>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Location</label>
        </div>
        <input type="text" required class="form-control" placeholder="location not defined" name="location"
               aria-describedby="emailHelp" value="{{ $wo['room']['block']->location_of_block }}" disabled>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Area</label>
        </div>
        <input type="text" required class="form-control" placeholder="area" name="area" aria-describedby="emailHelp"
               value="{{ $wo->room_id }}" disabled>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Block</label>
        </div>
        <input type="text" required class="form-control" placeholder="block" name="block" aria-describedby="emailHelp"
               value="{{ $wo['room']['block']->name_of_block }}" disabled>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Room</label>
        </div>
        <input type="text" required class="form-control" placeholder="room" name="room" aria-describedby="emailHelp"
               value="{{ $wo['room']->name_of_room }}" disabled>
    </div>
    <div class="form-group ">
        <label for="">Details:</label>
        <textarea name="details" required maxlength="100" class="form-control" rows="5"
                  id="comment" disabled>{{ $wo->details }}</textarea>
    </div>
    <br>
    <h4>Fill the details below to complete the work order.</h4>
    <form method="POST" action="{{ route('workOrder.edit', [$wo->id]) }}">
        @csrf
        <div class="form-group ">
            {{--<p>Is this work order emergency?</p>--}}
            @if($wo->emergency == 1)
                <input type="checkbox" name="emergency" checked> This work order is emergency.
            @else
                <input type="checkbox" name="emergency"> This work order is emergency.
            @endif
        </div>
        <div class="form-group ">
            {{--<p>Does this work order needs labourer?</p>--}}
            @if($wo->needs_laboured == 1)
                <input type="checkbox" name="labour" checked> This work order needs labourer.
            @else
                <input type="checkbox" name="labour"> This work order needs labourer.
            @endif
        </div>
        <div class="form-group ">
            {{--<p>Does this work order needs contractor?</p>--}}
            @if($wo->needs_contractor == 1)
                <input type="checkbox" name="contractor" checked> This work order needs contractor.
            @else
                <input type="checkbox" name="contractor"> This work order needs contractor.
            @endif
        </div>
        <button type="submit" class="btn btn-success">Save changes</button>
    </form>
    <br>
    <h4>Work order forms.</h4>
    {{-- tabs --}}
    <div class="col-md-8 payment-section-margin">
        <div class="tab">
            <div class="container-fluid">
                <div class="tab-group row">
                    <button class="tablinks col-md-4" onclick="openTab(event, 'customer')">INSPECTION FORM</button>
                    <button class="tablinks col-md-4" onclick="openTab(event, 'delivery')" id="defaultOpen">MATERIAL DETAILS</button>
                    <button class="tablinks col-md-4" onclick="openTab(event, 'payment')">TRANSPORTATION FORM
                    </button>
                </div>
            </div>

            {{-- INSPECTION tab--}}
            <form method="POST" action="{{ route('work.inspection', [$wo->id]) }}">
                @csrf
                <div id="customer" class="tabcontent">
                    <div class="row">
                        <div class="col-md-6">
                            <p>Work order status</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Status" name="status" type="text" required>
                    </div>
                    <p>Inspection description</p>
                    <div class="form-group">
                        <textarea name="details" required maxlength="100" class="form-control"  rows="5" id="comment"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Select Technician</label>
                        <select class="custom-select" required name="technician">
                            <option selected>Choose...</option>
                            @foreach($techs as $tech)
                                <option value="{{ $tech->id }}">{{ $tech->fname.' '.$tech->lname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-success">Save Inspections</button>
                </div>
            </form>
            {{-- end inspection --}}

            {{-- materials tab --}}
            <div id="delivery" class="tabcontent">
                <h4>Material Form</h4>
                <p>To be populated.</p>
            </div>

            {{-- transportation tab --}}
            <div id="payment" class="tabcontent">
                <h4>Transportation Form</h4>
                <p>To be populated.</p>
            </div>
        </div>
    </div>
    <br>
    @endSection