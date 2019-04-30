@extends('layouts.master')

@section('title')
    manage directorates
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
                    <button class="tablinks col-md-4" onclick="openTab(event, 'delivery')" id="defaultOpen">
                        DEPARTMENTS
                    </button>
                    <button class="tablinks col-md-4" onclick="openTab(event, 'payment')">SECTIONS
                    </button>
                </div>
            </div>

            {{-- directorate tab--}}
            <div id="customer" class="tabcontent">
                <a href="#new_dir" style="margin-bottom: 20px; background-color: coral; color: white"
                   class="btn btn-primary">Add new directorate</a>
                <table id="myTable" id="myTable" class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Abbreviation</th>
                        <th scope="col">Added on</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($directorates as $directorate)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $directorate->directorate_description }}</td>
                            <td>{{ $directorate->name }}</td>
                            <td>{{ $directorate->created_at }}</td>
                            <td>
                                <div class="row">
                                    <a style="color: green;" href="" data-toggle="tooltip" title="Edit"><i
                                                class="fas fa-edit"></i></a>
                                    <p>&nbsp;</p>
                                    <form method="POST" action="">
                                        {{csrf_field()}}
                                        <a title="Delete" style="color: red;" href="" data-toggle="tooltip"><i
                                                    class="fas fa-trash-alt"></i></a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <br>
                <h4 id="new_dir">Add new directorate</h4>
                <hr>
                <form method="POST" action="{{ route('directorate.save') }}" class="col-md-6">
                    @csrf
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
                    <button style="background-color: green; color: white" type="submit" class="btn btn-success">Save
                        directorate
                    </button>
                </form>
            </div>
            {{-- end inspection --}}

            {{-- department tab --}}
            <div id="delivery" class="tabcontent">
                <a href="#new_dep" style="margin-bottom: 20px; background-color: coral; color: white"
                   class="btn btn-primary">Add new department</a>
                <table id="myTablee" class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Abbreviation</th>
                        <th scope="col">Directorate</th>
                        <th scope="col">Added on</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($deps as $dep)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $dep->description }}</td>
                            <td>{{ $dep->name }}</td>
                            <td>{{ $dep['directorate']->name }}</td>
                            <td>{{ $dep->created_at }}</td>
                            <td>
                                <div class="row">
                                    <a style="color: green;" href="" data-toggle="tooltip" title="Edit"><i
                                                class="fas fa-edit"></i></a>
                                    <p>&nbsp;</p>
                                    <form method="POST" action="">
                                        {{csrf_field()}}
                                        <a title="Delete" style="color: red;" href="" data-toggle="tooltip"><i
                                                    class="fas fa-trash-alt"></i></a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


                <div class="text-center">

                </div>
                <br>
                <h4 id="new_dep">Add new department</h4>
                <hr>
                <form method="POST" action="{{ route('department.save') }}" class="col-md-6">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="directorate">Directorate/College</label>
                        </div>
                        <select required class="custom-select" name="directorate" id="directorate">
                            <option value="">Choose...</option>
                            @foreach($directorates as $directorate)
                                <option value="{{ $directorate->id }}">{{ $directorate->directorate_description }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="dep_name">Department name</label>
                        <input style="color: black" type="text" required class="form-control" id="dep_name"
                               name="dep_name" placeholder="Enter department name">
                    </div>
                    <div class="form-group ">
                        <label for="dep_ab">Department abbreviation</label>
                        <input style="color: black" type="text" required maxlength="8" class="form-control" id="dep_ab"
                               name="dep_ab" placeholder="Enter department abbreviation">
                    </div>
                    <p style="color: red">You must select a directorate/college to which you are adding a department</p>
                    <button style="background-color: green; color: white" type="submit" class="btn btn-success">Save
                        department
                    </button>
                </form>
            </div>

            {{-- section tab --}}
            <div id="payment" class="tabcontent">
                <a href="#new_sec" style="margin-bottom: 20px; background-color: coral; color: white"
                   class="btn btn-primary">Add new section</a>
                <table id="myTableee" class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Abbreviation</th>
                        <th scope="col">Department</th>
                        <th scope="col">Added on</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($secs as $sec)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $sec->section_name }}</td>
                            <td>{{ $sec->description }}</td>
                            <td>{{ $sec['department']->name }}</td>
                            <td>{{ $sec->created_at }}</td>
                            <td>
                                <div class="row">
                                    <a style="color: green;" href="" data-toggle="tooltip" title="Edit"><i
                                                class="fas fa-edit"></i></a>
                                    <p>&nbsp;</p>
                                    <form method="POST" action="">
                                        {{csrf_field()}}
                                        <a title="Delete" style="color: red;" href="" data-toggle="tooltip"><i
                                                    class="fas fa-trash-alt"></i></a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


                <div class="text-center">

                </div>
                <br>
                <h4 id="new_sec">Add new section</h4>
                <hr>
                <form method="POST" action="{{ route('section.save') }}" class="col-md-6">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="directorate">Directorate/College</label>
                        </div>
                        <select required class="custom-select" name="college" id="directorate"
                                onchange="getDepartments()">
                            <option selected value="">Choose...</option>
                            @foreach($directorates as $directorate)
                                <option value="{{ $directorate->id }}">{{ '('.$directorate->name . ') ' . $directorate->directorate_description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="department">Department</label>
                        </div>
                        <select required class="custom-select" name="department" id="department">
                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="sec_name">Section name</label>
                        <input style="color: black" type="text" required class="form-control" id="sec_name"
                               name="sec_name" placeholder="Enter section name">
                    </div>
                    <div class="form-group ">
                        <label for="sec_ab">Section abbreviation</label>
                        <input style="color: black" type="text" required maxlength="8" class="form-control" id="sec_ab"
                               name="sec_ab" placeholder="Enter section abbreviation">
                    </div>
                    <p style="color: red">You must select a department to which you are adding a section</p>
                    <button style="background-color: green; color: white" type="submit" class="btn btn-success">Save
                        section
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endSection


    <script>

        $(document).ready(function () {


            $('[data-toggle="tooltip"]').tooltip();

            $('#myTable').dataTable({
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            });

            $('#myTablee').DataTable();
            $('#myTableee').DataTable();
        });


    </script>