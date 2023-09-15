<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements IEntityRepository
{
    /**
     * @var Model
     */
    protected $model;


    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        $result = $this->model->find($id);
        if($result) {
            return $result;
        }
        return false;
    }

    public function findByCriteria(array $criteria, $orderBy = 'id', $order = 'desc')
    {
        $result = $this->model->where($criteria)->orderBy($orderBy, $order)->first();
        if($result) {
            return $result;
        }
        return false;
    }

    public function findByKey($key, $value, $orderBy = 'id', $order = 'desc')
    {
        $result = $this->model->where($key, $value)->orderBy($orderBy, $order)->first();
        if($result) {
            return $result;
        }
        return false;
    }

    public function findOrCreate($key, $value)
    {
        $result = $this->model->firstOrCreate([$key => $value]);
        if($result) {
            return $result;
        }
        return false;
    }

    public function findAllByKey($key, $value)
    {
        $result = $this->model->where($key, $value)->get();
        if($result) {
            return $result;
        }
        return false;
    }

    public function store($data,$key = 'id')
    {
        $id = isset($data[$key]) ? $data[$key] : null;
        $this->model->fill($data);
        if($this->model->validate($data)) {
            $result = $this->model->updateOrCreate(
                [$key => $id],
                $data
            );
            return $result;
        }
        return false;
    }

    public function save($data)
    {
        $this->model->fill($data);
        if($this->model->validate($data)) {
            $this->model->save();
            return $this->model;
        }
        return false;
    }

    public function update($id, $data)
    {
        $data['updated_at'] = Carbon::now();
        $this->model->fill($data);
        if($this->model->validate($data)) {
            if(!$this->model->where('id', $id)->update($data)) {
                return false;
            }
        }
        return true;
    }

    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    public function getModel()
    {
        return $this->model;
    }
}