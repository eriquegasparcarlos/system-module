<?php

namespace Modules\System\Http\Resources;

use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Facades\TenancyFacade;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        $hostname_currency  = app(Environment::class)->hostname();
        $url_array = explode('://', config('app.url'));
        $protocol = $url_array[0].'://';

        $url_array_new = explode(':', $url_array[1]);
        $port = ($url_array_new[1])?':'.$url_array_new[1]:'';

        $hostname = $protocol.$hostname_currency->fqdn.$port;

        return $this->collection->transform(function($row, $key) use($hostname) {
            $btn_send = false;
            $btn_cdr = false;

            if ($row->group_id === '01') {
                if ($row->state_type_id === '01') {
                    $btn_send = true;
                }
                if (in_array($row->state_type_id, ['05', '09', '11'])) {
                    $btn_cdr = true;
                }
            }

            return [
                'id' => $row->id,
                'external_id' => $row->external_id,
                'group_id' => $row->group_id,
                'state_type_id' => $row->state_type_id,
                'state_type_description' => get_description_table_system('state_types', $row->state_type_id),
                'hash' => $row->hash,
                'soap_type_id' => $row->soap_type_id,
                'soap_type_description' => get_description_table_system('soap_types', $row->soap_type_id),
                'date_of_issue' => $row->date_of_issue->format('d/m/Y'),
                'document_type_id' => $row->document_type_id,
                'document_type_short' => $row->document_type->short,
                'number' => $row->number_full,
                'response_code' => $row->response_code,
                'response_description' => $row->response_description,
                'btn_send' => $btn_send,
                'btn_cdr' => $btn_cdr,
//                'number' => $row->number,
//                'customer_name' => $row->customer->name,
//                'customer_number' => $row->customer->number,
//                'currency_type_id' => $row->currency_type_id,
//                'total_exportation' => $row->total_exportation,
//                'total_free' => $row->total_free,
//                'total_unaffected' => $row->total_unaffected,
//                'total_exonerated' => $row->total_exonerated,
//                'total_taxed' => $row->total_taxed,
//                'total_igv' => $row->total_igv,
//                'total' => $row->total,
//                'state_type_id' => $row->state_type_id,
//                'state_type_description' => $row->state_type->description,
//                'document_type_description' => $row->document_type->description,
//                'has_xml' => $has_xml,
//                'has_pdf' => $has_pdf,
//                'has_cdr' => $has_cdr,
                'download_xml' => $hostname.'/api/downloads/document/xml/'.$row->external_id,
                'download_cdr' => $hostname.'/api/downloads/document/cdr/'.$row->external_id,
                'download_pdf' => $hostname.'/api/downloads/document/pdf/'.$row->external_id,
//                'download_cdr' => $row->download_cdr,
//                'download_pdf' => $row->download_pdf,
                'loading' => false,
//                'download_pdf' => $row->download_external_pdf,

//                'btn_voided' => $btn_voided,
//                'btn_note' => $btn_note,
//                'btn_ticket' => $btn_ticket,
//                'btn_resend' => $btn_resend,
//                'btn_consult_cdr' => $btn_consult_cdr,
//                'send_server' => (bool) $row->send_server,
//                'voided' => $voided,
//                'affected_document' => $affected_document,
//                'has_xml_voided' => $has_xml_voided,
//                'has_cdr_voided' => $has_cdr_voided,
//                'download_xml_voided' => $download_xml_voided,
//                'download_cdr_voided' => $download_cdr_voided,
//                'shipping_status' => json_decode($row->shipping_status) ,
//                'sunat_shipping_status' => json_decode($row->sunat_shipping_status) ,
//                'query_status' => json_decode($row->query_status) ,
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),
            ];
        });
    }
}
