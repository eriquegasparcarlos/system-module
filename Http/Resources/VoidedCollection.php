<?php

namespace Modules\System\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VoidedCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request) {
        return $this->collection->transform(function($row, $key) {
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
                    'number' => $document->series.'-'.$document->number,
                    'date_of_issue' => $document->date_of_issue->format('d/m/Y'),
                    'total' => number_format($document->totals->total, 2)
                ];
            });

            return [
                'id' => $row->id,
                'external_id' => $row->external_id,
                'state_type_id' => $row->state_type_id,
                'state_type_description' => $row->state_type->description,
                'soap_type_id' => $row->soap_type_id,
                'soap_type_description' => $row->soap_type->description,
                'date_of_issue' => $row->date_of_issue->format('d/m/Y'),
                'date_of_reference' => $row->date_of_reference->format('d/m/Y'),
                'ticket' => $row->ticket,
                'documents' => $documents,
                'response_code' => $row->response_code,
                'response_description' => $row->response_description,
                'btn_send' => $btn_send,
                'btn_validate' => $btn_validate,
                'btn_cdr' => $btn_cdr,
                'download_xml' => $row->download_external_xml,
                'download_cdr' => $row->download_external_cdr,
                'loading' => false,
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),
            ];
        });
    }
}
