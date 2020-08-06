<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\house;
use App\hall;
use App\Notification;
use App\user;
use App\Campus;
use App\zone;
use App\cleaningarea;
use App\NonBuildingAsset;
use App\Area;
use App\Room;
use App\Block;
use App\Location;
use App\company;
use App\assetsland;
use App\assetsbuilding;
use App\assetscomputerequipment;
use App\assetsequipment;
use App\assetsfurniture;
use App\assetsintangible;
use App\assetsmotorvehicle;
use App\assetsplantandmachinery;
use App\assetsworkinprogress;

use App\assetsassesbuilding;
use App\assetsassescomputerequipment;
use App\assetsassesequipment;
use App\assetsassesfurniture;
use App\assetsassesintangible;
use App\assetsassesland;
use App\assetsassesmotorvehicle;
use App\assetsassesplantandmachinery;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class yearlySummary implements FromView, ShouldAutoSize //, WithHeadings
{

    public function view(): View
    {


            if($_GET['asset']=='Intangible')
            {
                $summary = assetsassesintangible::whereYear('assesmentYear',$_GET['year'])->get();

            }else if($_GET['asset']=='Furniture')
            {
                $summary = assetsassesfurniture::whereYear('assesmentYear',$_GET['year'])->get();

            }else if($_GET['asset']=='Equipment')
            {
                $summary = assetsassesequipment::whereYear('assesmentYear',$_GET['year'])->get();

            }else if($_GET['asset']=='ComputerEquipment')
            {
                $summary = assetsassescomputerequipment::whereYear('assesmentYear',$_GET['year'])->get();

            }else if($_GET['asset']=='MotorVehicle')
            {
                $summary = assetsassesmotorvehicle::whereYear('assesmentYear',$_GET['year'])->get();

            }else if($_GET['asset']=='PlantMachinery')
            {
                $summary = assetsassesplantandmachinery::whereYear('assesmentYear',$_GET['year'])->get();

            }else if($_GET['asset']=='Building')
            {
                $summary = assetsassesbuilding::whereYear('assesmentYear',$_GET['year'])->get();

            }else if($_GET['asset']=='Land')
            {
                $summary = assetsassesland::whereYear('assesmentYear',$_GET['year'])->get();

            }

             return view('exports.yearlyexport', [ 'assetdata' => $summary ]);



    }
}
