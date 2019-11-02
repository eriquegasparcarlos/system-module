<?php

namespace Modules\System\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Hyn\Tenancy\Environment;
use Illuminate\Http\Request;
use Modules\System\Helpers\ClientView;
use Modules\System\Helpers\VoidedClient;
use Modules\System\Http\Resources\VoidedCollection;
use Modules\System\Models\Client;
use Modules\Voided\Helpers\VoidedSave;
use Modules\Voided\Models\Voided;

class VoidedController extends Controller
{
    public function index()
    {
        return view('system::voided.index');
    }

    public function tables()
    {
        return [
            'clients' => ClientView::getAll(),
            'state_types' => get_table_system('state_types')
        ];
    }

    public function records($client_id)
    {
//        $hostname = Client::find($client_id)->hostname;
//        $website = $hostname->website;
//
//        $tenancy = app(Environment::class);
//
//        $tenancy->hostname($hostname);
//        $tenancy->tenant($website);
//
//        $voided_save = new VoidedSave();
//        $date_of_issue = Carbon::now()->format('Y-m-d');
//        $voided_save->save($date_of_issue, '01');
//
//        $records = Voided::orderBy('date_of_issue', 'desc')->get();
//
//        return new VoidedCollection($records);
    }

    public function send(Request $request)
    {
//        $client_id = $request->input('client_id');
//        $external_id = $request->input('external_id');
//        $voided_client = new VoidedClient($client_id);
//
//        return $voided_client->send($external_id);
    }
}