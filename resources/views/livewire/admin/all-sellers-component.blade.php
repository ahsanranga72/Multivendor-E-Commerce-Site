<div>
    <style>
        nav svg{
            height: 20px;
        }
        nav .hidden{
            display: block !important;
        }
    </style>
    <div class="container" style="padding: 30px 0">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                All Sellers
                            </div>

                        </div>
                    </div>
                    <div class="panel-body">
                        @if (Session::has('message'))
                            <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
                        @endif
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User Name</th>
                                    <th>Shop Name</th>
                                    <th>Shop Slug</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sellers as $seller)
                                    <tr>
                                        <td>{{$seller->id}}</td>
                                        <td>{{$seller->username}}</td>
                                        <td>{{$seller->shop_name}}</td>
                                        <td>{{$seller->shop_slug}}</td>
                                        <td>{{$seller->status}}</td>
                                        <td>
                                            <a href="{{route('admin.editseller',['seller_id'=>$seller->id])}}" >
                                                <i class="fa fa-edit fa-2x text-info"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{$sellers->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
