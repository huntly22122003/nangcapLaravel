<?php

namespace App\DTOs;

class ContactDTO
{
    public string $fullname;
    public ?string $email;
    public ?string $phone;
    public ?string $subject;
    public string $message;
    public bool $is_read;

    public function __construct(array $data)
    {
        $this->fullname = $data['fullname'] ?? '';
        $this->email = $data['email'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->subject = $data['subject'] ?? null;
        $this->message = $data['message'] ?? '';
        $this->is_read = $data['is_read'] ?? false;
    }

    public function toArray(): array
    {
        return [
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'subject' => $this->subject,
            'message' => $this->message,
            'is_read' => $this->is_read,
        ];
    }
}