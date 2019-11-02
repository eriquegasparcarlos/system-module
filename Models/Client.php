<?php

namespace Modules\System\Models;

use App\Models\ModelSystem;
use Hyn\Tenancy\Models\Hostname;

class Client extends ModelSystem
{
    protected $with = ['hostname'];
    protected $fillable = [
        'hostname_id',
        'number',
        'name',
        'email',
        'token',
        'locked',
    ];

    protected $sortable = [
        ['value' => 'name', 'label' => 'Nombre'],
        ['value' => 'number', 'label' => 'Número'],
    ];

    protected $defaultSortColumn = 'name';
    protected $defaultSortDirection = 'asc';

    public function hostname()
    {
        return $this->belongsTo(Hostname::class)->with(['website']);
    }
}