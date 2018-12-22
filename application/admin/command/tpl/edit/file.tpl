                <div class="form-group">
                    <label class="control-label col-xs-2">
                        {{comment}}&nbsp;
                    </label>
                    <div class="col-xs-8">
                        <input type="text" class="form-control" name="{{field}}"  value="{$data.{{field}}}" readonly  unselectable="on" required data-msg="请上传{{comment}}">
                    </div>
                    <div class="col-xs-2">
                        <button type="button" class="btn btn-primary spl_file_upload_btn">
                            上传
                        </button>
                        <input class="fileUpload form-control" type="file" name="file" style="display: none;" {{multiple}} data-type="{{data_type}}">
                    </div>
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-2"></div>
                            <div class="col-xs-8 spl_callback">
                                {if $data.{{field}} neq ''}
                                    {if '{{data_type}}' == 'file'}
                                        <div class="col-xs-8">
                                            <button type="button" class="btn btn-danger spl-delete-file" data-src="{$data.{{field}}}">删除</button>
                                        </div>
                                    {elseif '{{data_type}}' === 'image'}
                                        <div class="col-xs-3">
                                            <img src="{$data.{{field}}}">
                                            <button type="button" class="btn btn-danger spl-delete-file" data-src="{$data.{{field}}}">删除</button>
                                        </div>
                                    {/if}
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
