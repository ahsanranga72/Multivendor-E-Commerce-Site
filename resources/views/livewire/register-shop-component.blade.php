<div>
    <div class="container" style="padding: 30px 0">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Create Shop
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if (Session::has('message'))
                            <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
                        @endif
                        <form class="form-horizontal" wire:submit.prevent="storeshop">
                            <div class="form-group">
                                <label class="col-md-4 control-label">User Name</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="user Name" class="form-control input-md" wire:model="username" wire:keyup="generateslug" />
                                    @error('shop_slug')  <p class="text-danger">{{$message}}</p>  @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Shop Name</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="user Name" class="form-control input-md" wire:model="shop_name" />
                                    @error('shop_name')  <p class="text-danger">{{$message}}</p>  @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Shop URL</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Shop URL" class="form-control input-md" wire:model="shop_slug" />
                                    @error('shop_slug')  <p class="text-danger">{{$message}}</p>  @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
