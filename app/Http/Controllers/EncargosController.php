<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Encargo;
use App\DetalleEncargo;
use App\User; 
class EncargosController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $encargos = Encargo::join('clientes','encargos.id_cliente','=','clientes.id')
            ->select('encargos.id', 'encargos.anticipo','encargos.estado','encargos.fec_encargo','encargos.fec_entrega','clientes.nombre as cliente')
            ->orderBy('encargos.fec_encargo', 'asc')->paginate(3);
        }
        else{
            $encargos = Encargo::join('clientes','encargos.id_cliente','=','clientes.id')
            ->select('encargos.id', 'encargos.anticipo','encargos.estado','encargos.fec_encargo','encargos.fec_entrega','clientes.nombre as cliente')
            ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('fec_encargo', 'asc')->paginate(3);
        }

        return [
            'pagination' => [
                'total'        => $encargos->total(),
                'current_page' => $encargos->currentPage(),
                'per_page'     => $encargos->perPage(),
                'last_page'    => $encargos->lastPage(),
                'from'         => $encargos->firstItem(),
                'to'           => $encargos->lastItem(),
            ],
            'encargos' => $encargos
        ];
    } 
    public function obtenerDatos(Request $request){

        $id = $request->id;
        $encargos = Encargo::join('clientes','encargos.id_cliente','=','clientes.id')
        ->select('encargos.id','encargos.anticipo','encargos.estado','encargos.fec_encargo','encargos.fec_entrega',
        'clientes.nombre')
        ->where('encargos.id','=',$id)
        ->orderBy('encargos.id', 'desc')->take(1)->get();
        
        return ['encargos' => $encargos];

    }
    public function obtenerDetalles(Request $request){

        $id = $request->id;
        $detalle_encargos = DetalleEncargo::join('productos','detalle_encargos.id_producto','=','productos.id')
        ->select('detalle_encargos.cantidad','productos.nombre as producto')
        ->where('detalle_encargos.id_encargo','=',$id)
        ->orderBy('detalle_encargos.id', 'desc')->get();
        
        return ['detalle_encargos' => $detalle_encargos];
    }

    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            // $mytime= Carbon::now('America/Bogota');
            $encargos = new Encargo();
            $encargos->anticipo = $request->anticipo;
            // $encargos->fec_encargo = $mytime->toDateString();
            $encargos->estado = 'Registrado';
            $encargos->fec_entrega = $request->fec_entrega;
            $encargos->id_cliente = $request->id_cliente;
            $encargos->save();
            
            $detalles = $request->data;
            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleEncargo();
                $detalle->id_encargo = $encargos->id;
                $detalle->id_producto = $det['id_producto'];
                $detalle->cantidad = $det['cantidad'];    
                $detalle->save();
            } 
            DB::commit();
        } catch(Exception $e){
            DB::rollback();
        
        }
    }

    public function desactivar (Request $request)
    {
        $encargos = Encargo::findOrFail($request->id);
        $encargos->estado = 'Anulado';
        $encargos->save();
    }

}
