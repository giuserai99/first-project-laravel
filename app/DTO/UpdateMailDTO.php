<?php

namespace App\DTO;

class UpdateMailDTO {
    public function __construct(
        public int $id,
        public string $subject,
        public string $body,
    ) {}
}