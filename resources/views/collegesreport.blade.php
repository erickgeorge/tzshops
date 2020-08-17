<?php
namespace App\Http\Controllers;
use App\Directorate;
?>
<title><?php
    echo $header;
    ?></title>
<div style="margin-top: 20px" align="center"><h2>University of Dar es salaam</h2>
        <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">
        <p> <h5>Directorate of Estates Services</h5></p><p><b style="text-transform: uppercase;"><?php
         echo $header;
         ?></b></p>
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
    #footer{position:fixed; right:0px; bottom:10px; text-align:center; border-top:1px solid black; }
    #footer .page:before { content: "Page " counter(page); }
    @page {margin:20px 30px 40px 50px;}
    </style>
    <table>
     <thead class="thead-dark" align="center">

        <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Abbreviation</th>


        </tr>
     </thead>
     <tbody align="center">

                    <?php $i = 0;  ?>
                    @foreach($catch as $work)

                            <?php $i++ ?>
                            <tr>
                                <th scope="row">{{ $i }}</th>
                                <td >{{ $work->name }}</td>
                                <td>{{ $work->directorate_description }}</td>

                            </tr>
                    @endforeach
                    </tbody>
    </table>
    <div id='footer'>
        <p class="page"></p>
    </div>
