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

class OtherSummaryExport implements FromView, ShouldAutoSize //, WithHeadings
{

    public function view(): View
    {

        if($_GET['date']!='latest'){

            if($_GET['asset']=='Intangible')
            {
                $summary = assetsassesintangible::where('assesmentYear',$_GET['date'])->get();

            }else if($_GET['asset']=='Furniture')
            {
                $summary = assetsassesfurniture::where('assesmentYear',$_GET['date'])->get();

            }else if($_GET['asset']=='Equipment')
            {
                $summary = assetsassesequipment::where('assesmentYear',$_GET['date'])->get();

            }else if($_GET['asset']=='ComputerEquipment')
            {
                $summary = assetsassescomputerequipment::where('assesmentYear',$_GET['date'])->get();

            }else if($_GET['asset']=='MotorVehicle')
            {
                $summary = assetsassesmotorvehicle::where('assesmentYear',$_GET['date'])->get();

            }else if($_GET['asset']=='PlantMachinery')
            {
                $summary = assetsassesplantandmachinery::where('assesmentYear',$_GET['date'])->get();

            }else if($_GET['asset']=='Building')
            {
                $summary = assetsassesbuilding::where('assesmentYear',$_GET['date'])->get();

            }else if($_GET['asset']=='Land')
            {
                $summary = assetsassesland::where('assesmentYear',$_GET['date'])->get();

            }

             return view('exports.assetsSummaryDated', [ 'assetdata' => $summary ]);

        }
        else{

            if($_GET['asset']=='Intangible')
            {

            }else if($_GET['asset']=='Furniture')
            {

            }else if($_GET['asset']=='Equipment')
            {

            }else if($_GET['asset']=='ComputerEquipment')
            {

            }else if($_GET['asset']=='MotorVehicle')
            {

            }else if($_GET['asset']=='PlantMachinery')
            {

            }else if($_GET['asset']=='Building')
            {

            }else if($_GET['asset']=='Land')
            {

            }

            return view('exports.assetsSummary');
        }


    }
}
