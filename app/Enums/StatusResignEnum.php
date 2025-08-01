<?php

namespace App\Enums;

enum StatusResignEnum: string
{
    case Pending = 'pending';
    case Disetujui = 'disetujui';
    case Ditolak = 'ditolak';
}