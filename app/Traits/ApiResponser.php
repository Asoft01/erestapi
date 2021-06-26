<?php
    namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

trait ApiResponser{
        private function successResponse($data, $code){
            return response()->json($data, $code);
        }

        protected function errorResponse($message, $code){
            return response()->json(['error'=> $message, 'code' => $code], $code);
        }

        protected function showAll(Collection $collection, $code = 200){
            
            // $collection = $this->filterData($collection);
            $collection = $this->sortData($collection);
            $collection = $this->paginate($collection);
            $collection = $this->cache($collection);
            return $this->successResponse(['data' => $collection], $code);
        }

        protected function showOne(Model $model, $code = 200){
            return $this->successResponse(['data' => $model], $code);
        }

        protected function showMessage($message, $code= 200){
            return $this->successResponse(['data' => $message], $code);
        }

        // protected function fillData(Collection $collection){
        //     foreach (request()->query() as $query => $value) {
        //         // $attribute= $transformer::originalAttribute($query);

        //         if(isset($attribute, $value)){
        //             $collection = $collection->where($attribute, $value);
        //         }
        //     }

        //     return $collection;
        // }

        protected function paginate(Collection $collection){

            $rules = [
                'per_page' => 'integer|min:2|max:50'
            ];

            Validator::validate(request()->all(), $rules);

            $page = PaginationLengthAwarePaginator::resolveCurrentPage();
            $perPage = 15;

            if(request()->has('per_page')){
                $perPage = (int) request()->per_page;
            }

            $results = $collection->slice(($page-1) * $perPage, $perPage)->values();

            $paginated = new PaginationLengthAwarePaginator($results, $collection->count(), $perPage, $page, [
                'path' => PaginationLengthAwarePaginator::resolveCurrentPath(),
            ]);

            $paginated->appends(request()->all());
            return $paginated;
        }
        
        protected function sortData(Collection $collection){
            if(request()->has('sort_by')){
                $attribute= request()->sort_by;
                
                // $collection = $collection->sortBy($attribute);
                $collection = $collection->sortBy->{$attribute};
            }
            return $collection;
        }

        protected function cache($data){
            $url = request()->url();

            $queryParams = request()->query();
            ksort($queryParams);

            $queryString = http_build_query($queryParams);
            $fullUrl = "{$url}?{$queryString}";

            return Cache::remember($fullUrl, 30/60, function() use($data) {
                return $data;
            });
        }
    }
?>