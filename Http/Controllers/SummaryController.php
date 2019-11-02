<?php

namespace Modules\System\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Hyn\Tenancy\Environment;
use Illuminate\Http\Request;
use Modules\Summaries\Helpers\SummarySave;
use Modules\Summaries\Models\Summary;
use Modules\System\Helpers\ClientView;
use Modules\System\Helpers\SummaryClient;
use Modules\System\Http\Resources\SummaryCollection;
use Modules\System\Models\Client;

class SummaryController extends Controller
{
    public function index()
    {
        return view('system::summaries.index');
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
//        $summary_save = new SummarySave();
//        $date_of_issue = Carbon::now()->format('Y-m-d');
//        $summary_save->save($date_of_issue, '01');
//
//        $records = Summary::orderBy('date_of_issue', 'desc')->get();
//
//        return new SummaryCollection($records);
    }

    public function send(Request $request)
    {
//        $client_id = $request->input('client_id');
//        $external_id = $request->input('external_id');
//        $summary_client = new SummaryClient($client_id);
//
//        return $summary_client->send($external_id);
    }
}