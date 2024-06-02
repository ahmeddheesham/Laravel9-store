<?php

namespace App\Services;
use App\Models\Product;
use App\Repositorties\ProductRepository;
use App\Utils\ImageUpload;
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
        if (isset($params['image']))
        {
            $params['image'] = ImageUpload::uploadImage($params['image']);
        }
        $product = $this->prodctRepository->store($params);


        if (isset($params['colors'])) {
            $params['colors'] = array_map(function($color) use ($product) {
                $colors['color'] = $color;
                $colors['product_id'] = $product->id;
                return $colors;
            }, $params['colors']);

            $this->prodctRepository->addColor($product, ['colors' => $params['colors']]);
        }

        return $product;
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
        $query = $this->prodctRepository->baseQuery(relations:['category'],withCount:['productColor']);
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


            ->addColumn('category', function ($row) 
            {
                return $row->category->name;
            })

            ->rawColumns(['action'])
            ->make(true);
    }
}