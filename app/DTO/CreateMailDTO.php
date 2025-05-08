<?php

namespace App\DTO;

class CreateMailDTO {
    public function __construct(
        public array $emailsTo,
        public string $subject,
        public string $body,
    ) {}
}