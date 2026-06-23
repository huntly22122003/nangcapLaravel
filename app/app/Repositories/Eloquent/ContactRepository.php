<?php

namespace App\Repositories\Eloquent;

use App\Models\Contact;
use App\Repositories\Interfaces\ContactRepositoryInterface;

class ContactRepository implements ContactRepositoryInterface
{
    protected $model;

    public function __construct(Contact $contact)
    {
        $this->model = $contact;
    }

    public function all(array $filters = [], int $perPage = 20)
    {
        $query = $this->model->query();

        if (!empty($filters['search'])) {
            $query->where(function($q) use ($filters) {
                $q->where('fullname', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('email', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('phone', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('subject', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['is_read']) && $filters['is_read'] !== '') {
            $query->where('is_read', (bool)$filters['is_read']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $contact = $this->find($id);
        $contact->update($data);
        return $contact;
    }

    public function delete(int $id)
    {
        $contact = $this->find($id);
        return $contact->delete();
    }
}