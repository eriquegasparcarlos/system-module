<?php

namespace Modules\System\Http\Controllers;

use App\Http\Controllers\Controller;
use Hyn\Tenancy\Environment;
use Illuminate\Http\Request;
use Modules\Documents\Models\Document;
use Modules\System\Helpers\ClientView;
use Modules\System\Helpers\DocumentClient;
use Modules\System\Http\Resources\DocumentCollection;
use Modules\System\Models\Client;

class DocumentController extends Controller
{
    public function index()
    {
        return view('system::documents.index');
    }

    public function tables()
    {
        return [
            'clients' => ClientView::getAll(),
            'document_types' => get_table_tenant('document_types'),
            'state_types' => get_table_system('state_types')
        ];
    }

    public function records($client_id)
    {
        $hostname = Client::find($client_id)->hostname;
        $website = $hostname->website;

        $tenancy = app(Environment::class);

        $tenancy->hostname($hostname);
        $tenancy->tenant($website);

        $records = Document::orderBy('series_id', 'asc')
                           ->orderBy('number', 'desc')
                           ->orderBy('date_of_issue', 'desc')->get();

        return new DocumentCollection($records);
    }

    public function send(Request $request)
    {
        $client_id = $request->input('client_id');
        $external_id = $request->input('external_id');
        $document_client = new DocumentClient($client_id);

        return $document_client->send($external_id);
    }
}