    /**
    * 重写base fn index方法
    */
    public function index(){
        if(Request::isAjax()){
            list($where,$sort) = $this->buildQuery();

            $list = $this->model
                ->withJoin('{{withModelName}}')
                ->where($where)
                ->order($sort)
                ->paginate(Request::param('pageSize'));

            $list = $list->toArray();
            $data = [
                "total"=>$list['total'],
                'rows'=>$list['data'],
            ];
            return json($data);
        }
        return $this->fetch();
    }