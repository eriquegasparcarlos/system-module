<?php

namespace Modules\System\Http\Resources;

use Hyn\Tenancy\Environment;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SummaryCollection extends ResourceCollection
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
            $btn_validate = false;
            $btn_cdr = false;

            if ($row->state_type_id === '01') {
                $btn_send = true;
            }
            if ($row->state_type_id === '03') {
                $btn_validate = true;
            }
            if (in_array($row->state_type_id, ['05', '09', '11'])) {
                $btn_cdr = true;
            }

            $documents = collect($row->documents)->transform(function($d) {
                $document = $d->document;
                return [
                    'number' => $document->series->number.'-'.$document->number,
                    'date_of_issue' => $document->date_of_issue->format('d/m/Y'),
                    'total' => number_format($document->total, 2)
                ];
            });

            return [
                'id' => $row->id,
                'external_id' => $row->external_id,
                'state_type_id' => $row->state_type_id,
                'state_type_description' => get_description_table_system('state_types', $row->state_type_id),
                'summary_status_type_description' => $row->summary_status_type->description,
                'soap_type_id' => $row->soap_type_id,
                'soap_type_description' => get_description_table_system('soap_types', $row->soap_type_id),
                'date_of_issue' => $row->date_of_issue->format('d/m/Y'),
                'date_of_reference' => $row->date_of_reference->format('d/m/Y'),
                'ticket' => $row->ticket,
                'identifier' => $row->identifier,
                'documents' => $documents,
                'response_code' => $row->response_code,
                'response_description' => $row->response_description,
                'btn_send' => $btn_send,
                'btn_validate' => $btn_validate,
                'btn_cdr' => $btn_cdr,
                'download_xml' => '',//$row->download_external_xml,
                'download_cdr' => '',//$row->download_external_cdr,
                'loading' => false,
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),
            ];
        });
    }
}
