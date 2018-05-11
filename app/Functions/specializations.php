<?php
use App\Specialization;

function get_specializations() {
    return Specialization::all();
}