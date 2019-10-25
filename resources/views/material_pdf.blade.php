
<div style="margin-top: -20px" align="center">
    <img src="{{ public_path('/images/index.png') }}" height="100px" style="margin-top: 5px;" alt="udsm"> 
    <p><h2>University of Dar es salaam</h2> <h4>Director of Estates Services</h4></p><p><b>Material stock report</b></p>
</div><br>
<style>
table {
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</div>
        <table>
            <thead align="center">
            <tr>
               <th >#</th>
                <th >Name</th>
                <th >Brand</th>
                <th >Value/Capacity</th>
                <th >Type</th>
                <th >Stock</th>
                <th >Created at</th>
                <th >Updated at</th>
          
            </tr>
            </thead>

            <tbody align="center">

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $item->name }}</td>
                    <td id="wo-details">{{ $item->description }}</td>
                     <td>{{ $item->brand }}</td>
                    <td>{{ $item->type }}</td>
                   

                    <td>{{ $item->stock }}</td>
                    <td><?php $time = strtotime($item->created_at); echo date('d/m/Y',$time);  ?> </td>
                    <td><?php $time = strtotime($item->updated_at); echo date('d/m/Y',$time);  ?> </td>
                    
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>