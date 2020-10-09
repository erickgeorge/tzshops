@extends('layouts.master')

@section('title')
    works order
    @endSection

@section('body')
<style type="text/css">
    span{
        font-weight: bold;
    }
</style>
    <br>
    <div class="container">
    <div class="row container-fluid" >
        <div class="col-lg-12">

            <h4 >Works Order Details</h4>

        </div>
    </div>
    <hr>
    <div style="margin-right: 2%; margin-left: 2%;">
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
    <h5>Submitted by <span >{{ $wo['user']->fname.' '.$wo['user']->lname }}</span></h5>
    <h5>Submitted on <span >{{ date('d F Y', strtotime($wo->created_at)) }}</span></h5>
    <h3 >Contacts:</h3>
    <h5>Mobile Number:<span >  {{ $wo['user']->phone }}</span></h5>
    <h5>Email:        <span > {{ $wo['user']->email }}</span></h5>


    <br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Type of a problem</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="problem" name="problem"
               aria-describedby="emailHelp" value="{{ ucwords(strtolower($wo->problem_type))  }}" disabled>


    </div>

     @if(empty($wo->room_id))

      <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Location</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="location not defined" name="location"
               aria-describedby="emailHelp" value="{{ $wo->location }}" disabled>
    </div>


        @else



    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Location</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="location not defined" name="location"
               aria-describedby="emailHelp" value="{{ $wo['room']['block']->location_of_block }}" disabled>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Area</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="area" name="area" aria-describedby="emailHelp"
               value="{{ $wo['room']['block']['area']->name_of_area }}" disabled>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Block</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="block" name="block" aria-describedby="emailHelp"
               value="{{ $wo['room']['block']->name_of_block }}" disabled>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Room</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="room" name="room" aria-describedby="emailHelp"
               value="{{ $wo['room']->name_of_room }}" disabled>
    </div>

         @endif
    <div class="form-group ">
        <label for="">Description of the problem:</label>
        <textarea style="color: black" name="details" required maxlength="100" class="form-control" rows="5"
                  id="comment" disabled>{{ $wo->details }}</textarea>
    </div>

<br>
 @if(auth()->user()->type == 'Maintenance coordinator')
  @if($wo->problem_type == 'Others')  
  <p>Choose  problem type if you want to redirect to right section</p>

   <form method="POST" action="{{route('redirect_wo',[$wo->id])}}"
                  class="col-md-6">
                        @csrf
     
       <div class="form-group ">
                        <label for="dep_name">Problem Type</label>
                        <br>
                        <select style="width: 500px" required class="custom-select" name="p_type">
                           <option selected value="" >Choose problem type</option>
                                @foreach($sections as $section)
                                  <option value="{{ $section->section_name }}">{{ $section->section_name }}</option>
                                @endforeach
                        </select>
      </div>
         <button type="submit" class="btn btn-primary">Save</button>
 </form>  
  @endif
@endif  


 <h4>Wrong problem type?</h4>
    <form method="POST" action="{{ route('to.secretary.workorder', [$wo->id]) }}">
        @csrf
        <button type="submit" class="btn btn-primary">Send to Maintenance Coordinator</button>
    </form>
    <br>
   
  
<br>

<script>
function autoSubmit()
{
    var formObject = document.forms['theForm'];
    formObject.submit();
}
</script>

  <form  id='theForm1' method="POST" action="{{ route('workorder.accept', [$wo->id]) }}">
                @csrf

    <input name="emergency" <?php if ($wo->emergency == 1) { ?>checked='checked' <?php }?>   type="radio" value="emergency" onChange="autoSubmit();" /> &nbsp;This works order is emergency<br>
    <input name="emergency" <?php if ($wo->emergency == 0) { ?>checked='checked' <?php }?>  type="radio" value="notemergency" onChange="autoSubmit();" />&nbsp; This works order is not emergency

<br>
    <br>
     <div class="row">
        <div>
          
        <button type="submit" class="btn btn-primary">Accept</button>
            </form>
        </div>
        <p> &nbsp;&nbsp;</p>
        <div>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Reject</button>
            <a class="btn btn-info" href="/home" role="button">Cancel</a>
        </div>
    </div>
    <br>
   


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rejecting works order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please provide reason as to why you want to reject this works order.</p>
                    <form method="POST" action="{{ route('workorder.reject',['id'=>$wo->id]) }}">
                        @csrf
                        <textarea name="reason" required maxlength="100" class="form-control"  rows="5" id="reason"></textarea>
                        <br>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    @endSection
