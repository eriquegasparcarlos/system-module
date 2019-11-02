<?php

namespace Modules\System\Http\Resources;

use Hyn\Tenancy\Environment;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

class ClientCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {

        return $this->collection->transform(function($row, $key) {

            $tenancy = app(Environment::class);
            $tenancy->tenant($row->hostname->website);
//            $count_doc = DB::connection('tenant')->table('documents')->count();
//            $count_user = DB::connection('tenant')->table('users')->count();

            return [
                'id' => $row->id,
                'hostname' => $row->hostname->fqdn,
                'name' => $row->name,
                'email' => $row->email,
                'token' => $row->token,
                'number' => $row->number,
                'locked' => (bool) $row->locked,
//                'count_doc' => $count_doc,
//                'count_user' => $count_user,
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),
            ];
        });
    }
}