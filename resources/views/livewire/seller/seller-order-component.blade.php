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
                                All Products
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
                                    <th>Order number</th>
                                    <th>Item count</th>
                                    <th>Grand Total</th>
                                    <th>Shipping Address</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $orders as $subOrder )
                                    <tr>
                                        <td>{{$subOrder->order_id}}</td>
                                        <td>{{$subOrder->item_count}}</td>
                                        <td>{{$subOrder->grand_total}}</td>
                                        <td> {{$subOrder->order->line1}}</td>
                                        <td>{{$subOrder->status}}<td>
                                            @if($subOrder->status != 'completed')
                                                <a href=" {{route('order.delivered', $subOrder)}} " class="btn btn-primary btn-sm">mark as delivered</button>
                                            @endif
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
