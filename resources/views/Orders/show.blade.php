@extends('layouts.app-master', ['activePage' => 'orders',  'activeSub'=> 'orders',   'titlePage' => __('View Orders')])

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h3 class="card-title">Shipping Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th> Shipping Name : </th>
                                <th> {{ $order->name }} </th>
                            </tr>
                            <tr>
                                <th> Shipping Phone : </th>
                                <th> {{ $order->phone }} </th>
                            </tr>
                            <tr>
                                <th> Shipping Email : </th>
                                <th> {{ $order->email }} </th>
                            </tr>

                            <tr>
                                <th> Order Date : </th>
                                <th> {{ $order->order_date }} </th>
                            </tr>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
                    <div class="col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-header card-header-rose card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <h3 class="card-title">Order Details</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="card-body">
                        <table class="table">
                            <tr>
                                <th> Payment Type : </th>
                                <th> {{ $order->payment_method }} </th>
                            </tr>
                            <tr>
                                <th> Tranx ID : </th>
                                <th> {{ $order->transaction_id }} </th>
                            </tr>
                            <tr>
                                <th> Invoice : </th>
                                <th class="text-danger"> {{ $order->invoice_number }} </th>
                            </tr>
                            <tr>
                                <th> Order Total : </th>
                                <th>$ {{ $order->amount }} </th>
                            </tr>
                            <tr>
                                <th> Status : </th>
                                <th>
                                    <span class="badge badge-success">{{ $order->status }}
                                    </span>
                                </th>
                            </tr>
                            <tr>
                                <th>Return Reason: <p>{{ $order->return_reason }}</p></th>
                                <th>
                                    @if ($order->status == 'pending')
                                    <a href="{{ route('order-status.update', [
                                        'order_id' => $order->id,
                                        'status' => 'confirmed'
                                    ]) }}" class="btn btn-block btn-success">Confirm Order</a>
                                    @elseif ($order->status == 'confirmed')
                                    <a href="{{ route('order-status.update', [
                                        'order_id' => $order->id,
                                        'status' => 'processing'
                                    ]) }}" class="btn btn-block btn-success">Process Order</a>
                                    @elseif ($order->status == 'processing')
                                    <a href="{{ route('order-status.update', [
                                        'order_id' => $order->id,
                                        'status' => 'picked'
                                    ]) }}" class="btn btn-block btn-success">Pick Order</a>
                                    @elseif ($order->status == 'picked')
                                    <a href="{{ route('order-status.update', [
                                        'order_id' => $order->id,
                                        'status' => 'shipped'
                                    ]) }}" class="btn btn-block btn-success">Ship Order</a>
                                    @elseif ($order->status == 'shipped')
                                    <a href="{{ route('order-status.update', [
                                        'order_id' => $order->id,
                                        'status' => 'delivered'
                                    ]) }}" class="btn btn-block btn-success">Deliverd Order</a>
                                    @elseif ($order->status == 'cancel')
                                    <a href="{{ route('order-status.update', [
                                        'order_id' => $order->id,
                                        'status' => 'return'
                                    ]) }}" class="btn btn-block btn-danger">Return Order</a>
                                    @endif
                                </th>
                            </tr>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h3 class="card-title">Order View</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr style="background: #e3e3e3;">
                                        <td class="text-dark">
                                            <label for=""> Image</label>
                                        </td>
                                        <td class="text-dark">
                                            <label for=""> Product Name </label>
                                        </td>
                                        <td class="text-dark">
                                            <label for=""> Variant </label>
                                        </td>
                                        <td class="text-dark">
                                            <label for=""> Size </label>
                                        </td>
                                        <td class="text-dark">
                                            <label for=""> Quantity </label>
                                        </td>
                                        <td class="text-dark">
                                            <label for=""> Price </label>
                                        </td>
                                        <!--<td class="text-dark">-->
                                        <!--    <label for=""> Download </label>-->
                                        <!--</td>-->
                                    </tr>
                                    @foreach ($orderItems as $item)
                                        <tr>
                                            <td class="col-md-1">
                                                <label for=""><img src="{{ asset('public/assets/img/products/thumb/' . $item->product_thumbnail) }}"
                                                        height="50px;" width="50px;"> </label>
                                            </td>
                                            <td class="col-md-3">
                                                <label for=""> {{ $item->product_name }}</label>
                                            </td>
                                            <td class="col-md-2">
                                                <label for=""> {{ $item->variant }}</label>
                                            </td>
                                            <td class="col-md-2">
                                                <label for=""> {{ $item->size }}</label>
                                            </td>
                                            <td class="col-md-2">
                                                <label for=""> {{ $item->qty }}</label>
                                            </td>

                                            <td class="col-md-3">
                                                <label for=""> ${{ $item->unit_price }} ( $ {{ $item->unit_price * $item->qty }} ) </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection
