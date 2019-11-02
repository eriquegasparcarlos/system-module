<?php

namespace Modules\System\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Core\Data\ServiceData;
use Modules\System\Http\Requests\ClientRequest;
use Modules\System\Http\Resources\ClientCollection;
use Modules\System\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        return view('system::clients.index');
    }

    public function initTable()
    {
        return (new Client)->initTable();
    }

    public function records(Request $request)
    {
        $items_per_page = $request->get('limit');
        $sort_column = $request->get('sort_column');
        $sort_direction = $request->get('sort_direction');

        $records = Client::query()->with('hostname')->orderBy($sort_column, $sort_direction);

        return new ClientCollection($records->paginate($items_per_page));
    }

    public function tables()
    {
        return [
            'url_base' => '.'.config('configuration.app_url_base')
        ];
    }

    public function store(ClientRequest $request)
    {
        $website = new Website();

        try {
            $subDom = strtolower($request->input('subdomain'));
            $uuid = config('configuration.tenancy_database_prefix').'_'.$subDom;
            $fqdn = $subDom.'.'.config('configuration.app_url_base');

            $website->uuid = $uuid;
            app(WebsiteRepository::class)->create($website);

            //Hostname
            $hostname = new Hostname();
            $hostname->fqdn = $fqdn;
            $hostname = app(HostnameRepository::class)->create($hostname);
            app(HostnameRepository::class)->attach($hostname, $website);

            Client::query()->create([
                'hostname_id' => $hostname->id,
                'number' => $request->input('number'),
                'name' => $request->input('name'),
                'email' => strtolower($request->input('email')),
            ]);

        } catch (Exception $e) {

            app(WebsiteRepository::class)->delete($website, true);
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        if($request->input('with_data')) {
            $tenancy = app(Environment::class);
            $tenancy->tenant($website);

            DB::connection('tenant')->transaction(function () use($request) {

                DB::connection('tenant')->table('templates')->insert([
                    ['id' => 1, 'document_name' => 'sale', 'name' => 'Modelo 1', 'value' => 'model_1', 'image' => 'model_1.jpg', 'default' => true],
                    ['id' => 2, 'document_name' => 'sale', 'name' => 'Modelo 2', 'value' => 'model_2', 'image' => 'model_2.jpg', 'default' => false],
                    ['id' => 3, 'document_name' => 'sale', 'name' => 'Modelo 3', 'value' => 'model_3', 'image' => 'model_3.jpg', 'default' => false],
                    ['id' => 4, 'document_name' => 'sale', 'name' => 'Modelo 4', 'value' => 'model_4', 'image' => 'model_4.jpg', 'default' => false],
                    ['id' => 5, 'document_name' => 'quotation', 'name' => 'Modelo 1', 'value' => 'model_1', 'image' => 'model_1.jpg', 'default' => false],
                    ['id' => 6, 'document_name' => 'quotation', 'name' => 'Modelo 2', 'value' => 'model_2', 'image' => 'model_2.jpg', 'default' => false],
                    ['id' => 7, 'document_name' => 'quotation', 'name' => 'Modelo 3', 'value' => 'model_3', 'image' => 'model_3.jpg', 'default' => false],
                    ['id' => 8, 'document_name' => 'quotation', 'name' => 'Modelo 4', 'value' => 'model_4', 'image' => 'model_4.jpg', 'default' => true],
                ]);

                $company_configurations = company_configuration_general([]);

                DB::connection('tenant')->table('companies')->insert([
                    'number' => $request->input('number'),
                    'name' => $request->input('name'),
                    'trade_name' => $request->input('name'),
                    'logo' => null,
                    'url_web' => null,
                    'url_cpe' => null,
                    'configurations' =>json_encode($company_configurations),
                    'activity_id' => $request->input('activity_id'),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                DB::connection('tenant')->table('environments')->insert([
                    'soap_type_id' => '01',
                    'soap_username' => null,
                    'soap_password' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $establishment_configurations = establishment_configuration_general([]);

                $establishment_id = DB::connection('tenant')->table('establishments')->insert([
                    'internal_id' => 'principal',
                    'name' => 'OFICINA PRINCIPAL',
                    'country_id' => 'PE',
                    'location_id' => '150101',
                    'address' => '-',
                    'email' => '-',
                    'phone' => '(+511)',
                    'code' => '0000',
                    'configurations' =>json_encode($establishment_configurations),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                DB::connection('tenant')->table('series')->insert([
                    ['establishment_id' => $establishment_id, 'document_type_id' => '01', 'number' => 'F001'],
                    ['establishment_id' => $establishment_id, 'document_type_id' => '03', 'number' => 'B001'],
                    ['establishment_id' => $establishment_id, 'document_type_id' => '07', 'number' => 'FC01'],
                    ['establishment_id' => $establishment_id, 'document_type_id' => '07', 'number' => 'BC01'],
                    ['establishment_id' => $establishment_id, 'document_type_id' => '08', 'number' => 'FD01'],
                    ['establishment_id' => $establishment_id, 'document_type_id' => '08', 'number' => 'BD01'],
                    ['establishment_id' => $establishment_id, 'document_type_id' => 'U1', 'number' => 'C001'],
                ]);

                DB::connection('tenant')->table('users')->insert([
                    'name' => 'Admin',
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password')),
                    'api_token' => null,
                    'role_id' => 'super',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
        }

        return [
            'success' => true,
            'message' => "Cliente {$request->input('name')} registrado con éxito"
        ];
    }

    public function destroy($id)
    {
        $client = Client::query()->find($id);

        $hostname = Hostname::query()->findOrFail($client->hostname_id);
        $website = Website::query()->findOrFail($hostname->website_id);

        app(HostnameRepository::class)->delete($hostname, true);
        app(WebsiteRepository::class)->delete($website, true);

        return [
            'success' => true,
            'message' => 'Cliente eliminado con éxito'
        ];
    }

    public function service($type, $number)
    {
        return ServiceData::service($type, $number);
    }
}
