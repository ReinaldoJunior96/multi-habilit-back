<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('fila-chamada', function ($user) {
    return true; // Permissão para o canal
});
