<div style="margin-top: -20px" align="center">
    <img src="{{ public_path('/images/index.png') }}" height="100px" style="margin-top: 5px;" alt="udsm"> 
    <p><h2>University of Dar es salaam</h2> <h4>Director of Estates Services</h4></p><p><b>System users report</b></p>
</div><br>

<style>
table {
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 3px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>

<table>
  <thead class="thead-dark" align="center">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Full Name</th>
     
      <th scope="col">Email</th>
      <th title="phone" scope="col">Phone</th>
      <th scope="col">Type</th>
    <th scope="col">Directorate</th>
      <th scope="col">Department</th>
  
 
    </tr>
  </thead>
  <tbody align="center">
  <?php 

 if (isset($_GET['page'])){
if ($_GET['page']==1){

  $i=1;
}else{
  $i = ($_GET['page']-1)*5+1; }
}
else {
 $i=1;
}
 $i=1;

   ?>
    @foreach($display_users as $user)
    <tr>
      <th scope="row">{{ $i++ }}</th>
      <td>{{ $user->fname . ' ' . $user->lname }}</td>
   
      <td><a style="color: #000;" href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
      <td>{{ $user->phone }}</td>
      <td>{{ $user->type }}</td>
        <td>{{ $user['section']['department']['directorate']->name }}</td>
      <td>{{ $user['section']['department']->name }}</td>
   
     
      </td>
    </tr>
    @endforeach
  </tbody>

 
</table>

</div>
  