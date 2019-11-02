<?php

namespace Modules\System\Helpers;

use Exception;
use Hyn\Tenancy\Environment;
use Modules\CoreFacturalo\Summary\SummarySend;
use Modules\Summaries\Models\Summary;
use Modules\System\Models\Client;

class SummaryClient
{
    public function __construct($client_id)
    {
        $hostname = Client::find($client_id)->hostname;
        $website = $hostname->website;
        $tenancy = app(Environment::class);
        $tenancy->hostname($hostname);
        $tenancy->tenant($website);
    }

    public function send($external_id)
    {
        $summary_send = new SummarySend($this->getSummaryByExternalId($external_id));
        $response = $summary_send->senderXmlSigned();

        return $response;
    }

    private function getSummaryByExternalId($external_id)
    {
        $summary = Summary::where('external_id', $external_id)->first();
        if (!$summary) {
            throw new Exception("El resumen con código externo: {$external_id} no existe.");
        }

        return $summary;
    }
}