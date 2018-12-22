                <div class="form-group">
                    <label class="control-label col-xs-2">
                        {{comment}}&nbsp;
                    </label>
                    <div class="col-xs-8">
                        <input  class="form-control dateTimePicker"  type="text" name="{{field}}"  value="{$data.{{field}}|date='Y-m-d H:i:s'}" required data-msg="请设置{{comment}}">
                    </div>
                </div>
