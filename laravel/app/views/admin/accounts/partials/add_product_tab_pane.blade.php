<div class="tab-pane fade" id="add-product">
                    <div class="row">
                        <div class="col-lg-10">
                        <h2>Add Product</h2>
                        <hr>
                            
                            {{-- <div class="tabbable"> --}}
                              <div class="row">
                                <div class="col-xs-7 col-xs-offset-1">
                                  <ul class="nav nav-tabs">
                                      <li class="active">
                                          <a href="#add-recurring" data-toggle='tab'>Recurring</a>
                                      </li>
                                      <li>
                                          <a href="#add-non-recurring" data-toggle='tab'>
                                              Non Recurring
                                          </a>
                                      </li>
                                  </ul>
                                </div>
                              </div>
                            <div class="tab-content">
                              <div class="tab-pane fade" id="add-non-recurring">
                              <br>
                                  <div class="row">
                                    <div class="col-lg-7 col-lg-offset-1">
                                        {{Form::open(['route'=>'subscriber.product.add.nonrecurring','class'=>'form-horizontal','role'=>'form'])}}
                                        {{Form::hidden('user_id', $profile->id)}}
                                        {{Form::hidden('taxable', 0)}}
                                        <fieldset>
                                          <div class="form-group {{Form::error($errors, 'name')}}">
                                              <label for="inputEmail" class="col-lg-3 control-label">Name</label>
                                              <div class="col-lg-8  ">
                                                {{Form::text('name',NULL,['class'=>'form-control','placeholder'=>'product name'])}}
                                                  {{$errors->first('name',"<span class='help-block'>:message</span>")}}
                                              </div>
                                          </div>
                                            <div class="form-group {{Form::error($errors, 'price')}}">
                                              <label for="inputEmail" class="col-lg-3 control-label">Product Price</label>
                                              <div class="col-lg-8">
                                                {{Form::text('price', NULL, ['class'=>'form-control','placeholder'=>"product price"])}}
                                                {{$errors->first('price',"<span class='help-block'>:message</span>")}}
                                              </div>
                                          </div>
                                            
                                          <div class="form-group  {{Form::error($errors, 'taxable')}}">
                                              <label for="taxable" class="col-lg-3 control-label">Taxable</label>
                                              <div class="col-lg-1">
                                                {{Form::checkbox('taxable', 1)}}
                                                {{$errors->first('taxable',"<span class='help-block'>:message</span>")}}
                                              </div>
                                              <label for="tax_rate" class="col-lg-2 control-label">Tax Percent</label>
                                              <div class="col-lg-5">
                                                {{Form::text('tax_rate', NULL, ['class'=>'form-control','placeholder'=>"tax percentage"])}}
                                                {{$errors->first('tax_rate',"<span class='help-block'>:message</span>")}}
                                              </div>
                                          </div>
                                            
                                        <div class="form-group">
                                              <div class="col-lg-10 col-lg-offset-4">
                                                {{Form::buttons()}}
                                              </div>
                                            </div>
                                        </fieldset>
                                        {{Form::close()}}
                                    </div>
                                </div>
                              </div>
                              <div class="tab-pane fade active in" id="add-recurring">
                              <br>
                                  <div class="row">
                                <div class="col-lg-7 col-lg-offset-1">
                                    {{Form::open(['route'=>'subscriber.product.add.recurring','class'=>'form-horizontal','role'=>'form'])}}
                                    {{Form::hidden('user_id', $profile->id)}}
                                    {{Form::hidden('taxable', 0)}}
                                    <fieldset>
                                      <div class="form-group {{Form::error($errors, 'name')}}">
                                          <label for="inputEmail" class="col-lg-3 control-label">Name</label>
                                          <div class="col-lg-8  ">
                                            {{Form::text('name',NULL,['class'=>'form-control','placeholder'=>'product name'])}}
                                              {{$errors->first('name',"<span class='help-block'>:message</span>")}}
                                          </div>
                                      </div>
                                        <div class="form-group {{Form::error($errors, 'price')}}">
                                          <label for="inputEmail" class="col-lg-3 control-label">Product Price</label>
                                          <div class="col-lg-8">
                                            {{Form::text('price', NULL, ['class'=>'form-control','placeholder'=>"product price"])}}
                                            {{$errors->first('price',"<span class='help-block'>:message</span>")}}
                                          </div>
                                      </div>
                                        <div class="form-group">
                                          <label for="billing_cycle" class="col-lg-3 control-label">Recur Every</label>
                                          <div class="col-lg-4">
                                              {{Form::text('billing_cycle',NULL,['class'=>'form-control','placeholder'=>'billing cycle'])}}
                                          </div>
                                          <div class="col-lg-4">
                                              {{Form::select('billing_unit',['Months'=>'Months'],NULL,['class'=>'form-control'])}}
                                          </div>
                                      </div>
                                      <div class="form-group  {{Form::error($errors, 'taxable')}}">
                                          <label for="expiry" class="col-lg-3 control-label">Expires On</label>
                                          <div class="col-lg-8">
                                            {{Form::text('expiry', NULL, ['class'=>'form-control','placeholder'=>"product expiration date",'id'=>'expiry'])}}
                                            {{$errors->first('expiry',"<span class='help-block'>:message</span>")}}
                                          </div>
                                      </div>
                                      <div class="form-group  {{Form::error($errors, 'taxable')}}">
                                          <label for="taxable" class="col-lg-3 control-label">Taxable</label>
                                          <div class="col-lg-1">
                                            {{Form::checkbox('taxable', 1)}}
                                            {{$errors->first('taxable',"<span class='help-block'>:message</span>")}}
                                          </div>
                                          <label for="tax_rate" class="col-lg-3 control-label">Tax Percent</label>
                                          <div class="col-lg-4">
                                            {{Form::text('tax_rate', NULL, ['class'=>'form-control','placeholder'=>"tax percentage"])}}
                                            {{$errors->first('tax_rate',"<span class='help-block'>:message</span>")}}
                                          </div>
                                      </div>
                                    <div class="form-group">
                                          <div class="col-lg-10 col-lg-offset-4">
                                            {{Form::buttons()}}
                                          </div>
                                        </div>
                                    </fieldset>
                                    {{Form::close()}}
                                </div>
                            </div>
                              </div>
                            </div>
                            {{-- </div> --}}
                            
                            
                            
                        </div>
                    </div>
                </div>