<?php

namespace App\DTO;

class UpdateMailDTO {
    public function __construct(
        public string $subject,
        public string $body,
    ) {}
}