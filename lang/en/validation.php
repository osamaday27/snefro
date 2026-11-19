<?php

return [
    'required' => 'The :attribute field is required.',
    'email'    => 'Please enter a valid email address.',
    'string'   => 'The :attribute must be text.',
    'numeric'  => 'The :attribute must be a number.',
    'integer'  => 'The :attribute must be a whole number.',
    'image'    => 'The :attribute must be an image.',
    'regex'    => 'The :attribute format is invalid.',
    'exists'   => 'The selected :attribute is invalid.',
    'in'       => 'The selected :attribute is invalid.',
    'uploaded' => 'The :attribute failed to upload.',
    'min' => [
        'string'  => 'The :attribute must be at least :min characters.',
        'numeric' => 'The :attribute must be at least :min.',
        'array'   => 'The :attribute must have at least :min items.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
    ],
    'max' => [
        'string'  => 'The :attribute may not be greater than :max characters.',
        'numeric' => 'The :attribute may not be greater than :max.',
        'array'   => 'The :attribute may not have more than :max items.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
    ],
    'lt' => ['numeric' => 'The :attribute must be less than :value.'],
    'attributes' => [
        'customer_name' => 'full name', 'phone' => 'mobile number', 'email' => 'email',
        'address' => 'address', 'city' => 'governorate', 'notes' => 'notes', 'name' => 'name',
    ],
];
