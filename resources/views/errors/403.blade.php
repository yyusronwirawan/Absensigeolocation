@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('message', __($exception->getMessage() ?: 'Anda tidak memiliki akses'))
