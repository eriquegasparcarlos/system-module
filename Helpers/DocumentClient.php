<?php

namespace Modules\System\Helpers;

use Exception;
use Hyn\Tenancy\Environment;
use Modules\CoreFacturalo\Document\DocumentSend;
use Modules\Documents\Models\Document;
use Modules\System\Models\Client;

class DocumentClient
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
        $document_send = new DocumentSend($this->getDocumentByExternalId($external_id));
        $response = $document_send->senderXmlSigned();

        return $response;
    }

    private function getDocumentByExternalId($external_id)
    {
        $document = Document::where('external_id', $external_id)->first();
        if (!$document) {
            throw new Exception("El documento con código externo: {$external_id} no existe.");
        }

        return $document;
    }
}