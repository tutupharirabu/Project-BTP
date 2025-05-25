<?php

namespace App\Enums;

enum StatusRuangan: string
{
    case Tersedia = 'Tersedia';
    case Digunakan = 'Digunakan';
    case Penuh = 'Penuh';
}