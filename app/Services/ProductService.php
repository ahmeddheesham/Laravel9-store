<?php

namespace App\Services;
use App\Models\Product;
use App\Repositorties\ProductRepository;
use Yajra\DataTables\Facades\DataTables;

class ProductService
{
    public $prodctRepository;
    public function __construct(ProductRepository $repo)
    {
        $this->prodctRepository = $repo;
    }

    public function getAll()
    {
        return $this->prodctRepository->baseQuery();
    }

    public function getById($id)
    {
        return $this->prodctRepository->getById($id);
    }

    public function store($params)
    {
        return $this->prodctRepository->store($params);
    }

    public function update($id, $params)
    {
        return $this->prodctRepository->update($id, $params);
    }

    public function delete($params)
    {
        return $this->prodctRepository->delete($params);
    }


    public function datatable()
    {
        $query = $this->prodctRepository->baseQuery(['parent']);
        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                return $btn = '
                        <a href="' . Route('dashboard.categories.edit', $row->id) . '"
                          class="edit btn btn-success btn-sm" >
                          <i class="fa fa-edit"></i>
                          </a>

                        <button 
                        type="button" 
                        id="deleteBtn"  
                        data-id="' . $row->id . '" 
                        class="btn btn-danger mt-md-0 mt-2" 
                        data-bs-toggle="modal"
                        data-original-title="test" 
                        data-bs-target="#deletemodal">
                        <i class="fa fa-trash"></i>
                        </button>';
            })

            ->rawColumns(['action'])
            ->make(true);
    }
}