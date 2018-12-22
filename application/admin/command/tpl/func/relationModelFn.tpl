
    /**
    *   {{comment}}关联表查找
    */
    public function {{relationLeftJoinFn}}(){
        return $this->belongsTo('{{relationModelName}}','{{foreignKey}}','{{pk}}',[],'left');
    }
