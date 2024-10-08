<?php

namespace RelayWP\LPoints\App\Services\Validation;

use RelayWP\LPoints\App\Services\Request\Request;

interface FormRequest
{
    public function rules(Request $request);

    public function messages(): array;
}

