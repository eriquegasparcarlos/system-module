<?php

namespace Modules\System\Helpers;

use Modules\System\Models\Client;

class ClientView
{
    public static function getAll()
    {
        return Client::all()->transform(function($row) {
            return [
                'id' => $row->id,
                'description' => $row->number.' - '.$row->name
            ];
        });
    }
}