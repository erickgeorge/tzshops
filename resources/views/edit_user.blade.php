@extends('layouts.master')

@section('title')
    User Registrartion
    @endSection

@section('body')
    <br>
    <div class="row">
        <div class="col-md-8">
            <h2>Edit user</h2>
        </div>
        {{--<div class="col-md-4">
            <a href="{{ url('viewusers') }}">
                <button type="" class="btn btn-primary">View all users</button>
            </a>
        </div>--}}
    </div>
    <br>
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
        <form method="POST" action="{{ route('user.edit', [$user->id]) }}">
            @csrf

            <div class="form-group ">
                <label for="fname">First name</label>
                <input style="color: black" type="text" required maxlength="20" class="form-control" id="fname" aria-describedby="emailHelp"
                       name="fname" placeholder="Enter first name"
                       onkeypress="return  event.charCode > 57 " value="{{ $user->fname }}">
            </div>
            <div class="form-group ">
                <label for="lname">Last name</label>
                <input style="color: black" type="text" required maxlength="20" class="form-control" id="lname" aria-describedby="emailHelp"
                       name="lname" placeholder="Enter last name" onkeypress="return  event.charCode > 57 "
                       value="{{ $user->lname }}">
            </div>
            <div class="form-group ">
                <label for="phone">Phone number</label>
                <input style="color: black" required type="text" name="phone" value="{{ $user->phone }}"
                       oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                       maxlength="13" minlength="2"
                       class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter phone number"
                       onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) || event.charCode==43 ">
            </div>
            <div class="form-group ">
                <label for="email">Email Address</label>
                <input style="color: black" required type="email" maxlength="25" class="form-control" id="email" aria-describedby="emailHelp"
                       name="email" placeholder="Enter email address" value="{{ $user->email }}">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="directorate">Directorate/College</label>
                </div>
                <select class="custom-select" name="college" id="directorate" onchange="getDepartments()">
                    @foreach($directorates as $directorate)
                        <option <?php if(($user['section']['department']['directorate']->name) == $directorate->name) {?>
                                selected="selected"
								<?php } ?>
                                value="{{ $directorate->id }}" > {{ '('.$directorate->name . ') ' . $directorate->directorate_description }}</option>
                    @endforeach 

                </select>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="department">Department</label>
                </div>
                <select class="custom-select" name="department" id="department" onchange="getSections()">
                    <option value="{{ $user['section']['department']->id }}">{{ $user['section']['department']->description }}</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="section">Section</label>
                </div>
                <select class="custom-select" name="section" id="section">
                    <option value="{{ $user['section']->id }}">{{ $user['section']->section_name }}</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Role</label>
                </div>
                <select class="custom-select" name="role" id="inputGroupSelect02">

                    <option

                            @if(($trole['user_role']['role_id']) =="1")
                            selected="selected"
                            @else

                            @endif
                            value="1">Admin
                    </option>
                    <option
                            @if(($trole['user_role']['role_id']) =="2")
                            selected="selected"
                            @else

                            @endif
                            value="2">Staff
                    </option>
                </select>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Type of User</label>
                </div>
                <select class="custom-select" id="inputGroupSelect02" name="user_type">

                    <option
                            @if(($user->type) =="HOS Electrical")
                            selected="selected"
                            @endif
                            value="HOS Electrical">HOS Electrical
                    </option>
                    <option
                            @if(($user->type) =="HOS Plumbing")
                            selected="selected"
                            @endif
                            value="HOS Plumbing">HOS Plumbing
                    </option>

                    <option
                            @if(($user->type) =="HOS Carpentry/Painting")
                            selected="selected"
                            @endif
                            value="HOS Carpentry/Painting">HOS Carpentry/Painting
                    </option>


                    <option
                            @if(($user->type) =="HOS Mechanical")
                            selected="selected"
                            @endif
                            value="HOS Mechanical">HOS Mechanical
                    </option>


                    <option
                            @if(($user->type) =="HOS Masonry/Road")
                            selected="selected"
                            @endif
                            value="HOS Masonry/Road">HOS Masonry/Road
                    </option>
                    <option
                            @if(($user->type) =="Maintenance Coordinator")
                            selected="selected"
                            @endif
                            value="Maintenance Coordinator">Maintenance Coordinator
                    </option>
                    <option
                            @if(($user->type) =="DVC Admin")
                            selected="selected"
                            @endif
                            value="DVC Admin">DVC Admin
                    </option>
                    <option
                            @if(($user->type) =="Store Manager")
                            selected="selected"
                            @endif
                            value="Store Manager">Store Manager
                    </option>
                    <option
                            @if(($user->type) =="Secretary")
                            selected="selected"
                            @endif
                            value="Secretary">Secretary
                    </option>
                    <option
                            @if(($user->type) =="Technician")
                            selected="selected"
                            @endif
                            value="Technician">Technician
                    </option>
                    <option
                            @if(($user->type) =="Estates Director")
                            selected="selected"
                            @endif
                            value="Estates Director">Estates Director
                    </option>
                    <option
                            @if(($user->type) =="Inspector Of Works")
                            selected="selected"
                            @endif
                            value="Inspector Of Works">Inspector Of Works
                    </option>

                </select>
            </div>

 <!-- 
            <div class="form-group ">
                <label for="uname">Username</label>
                <input style="color: black" required maxlength="20" type="text" class="form-control"
                       id="uname" name="uname" aria-describedby="emailHelp"
                       placeholder="Enter username" value="{{ $user->name }}" disabled data-toggle="tooltip"
                       title="Cannot edit username">
            </div>
			
			-->
		

            <button type="submit" style="background-color:#2E77BB;border-color:#2E77BB;" class="btn btn-success">Save</button>
            <a class="btn btn-info" style="background-color:#F9B100;border-color:#F9B100" href="/viewusers" role="button">Cancel</a>

        </form>

    </div>
    <br>


    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
		
		
		
    </script>
    @endSection