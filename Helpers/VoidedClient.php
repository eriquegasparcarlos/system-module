<?php

namespace Modules\System\Helpers;

use Exception;
use Hyn\Tenancy\Environment;
use Modules\CoreFacturalo\Voided\VoidedSend;
use Modules\System\Models\Client;
use Modules\Voided\Models\Voided;

class VoidedClient
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
        $voided_send = new VoidedSend($this->getVoidedByExternalId($external_id));
        $response = $voided_send->senderXmlSigned();

        return $response;
    }

    private function getVoidedByExternalId($external_id)
    {
        $voided = Voided::where('external_id', $external_id)->first();
        if (!$voided) {
            throw new Exception("La anulación con código externo: {$external_id} no existe.");
        }

        return $voided;
    }
}