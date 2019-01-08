@extends('layouts.personal-office')
@push('page-styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.css">
@endpush
@push('page-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.js"></script>
    <script>
        $(".btn-paymant").on('click', function () {
            event.preventDefault();
            var data = $(event.target).data();
            console.log(data)
            $.confirm({
                title: 'Confirm Payment?',
                content: 'Price: ' + data.price.toFixed(2) + ' {{$currency}}',
                type: 'green',
                buttons: {
                    ok: {
                        text: 'Pay ' + data.price.toFixed(2) + ' {{$currency}}',
                        btnClass: 'btn-success',
                        keys: ['enter'],
                        action: function () {
                            $('.payment-' + data.method + '-' + data.service + '-' + data.plan).submit();
                        }
                    },
                    cancel: function () {
                    }
                }
            });
        });
    </script>
@endpush
@section('page')
    <div class="container-fluid-md">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><i class="fa fa-list-alt text-success"></i> @lang('personal-office/products/deposits/btc.product_list')</h4>
                        <p class="alert alert-info"><span class="text-danger">*</span> @lang('personal-office/products/deposits/btc.tax_vary')</p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            @foreach($products as $plan => $product)
                                <?php $product->id = $plan;?>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div
                                        class="panel product product-{{$product->count ?? 0 > 0 ? '1' : '0'}}  @if($product->best) product-best @endif">
                                        <div
                                            class="product-body product-body-{{$product->count ?? 0 > 0 ? '1' : '0'}}">
                                    <span
                                        class="label product-label product-label-{{$product->count ?? 0 > 0 ? '1' : '0'}}"> {{$product->count ?? 0}} </span>
                                            <span class="label-title">@lang('personal-office/products/deposits/btc.count')</span>
                                            <ul class="list-group no-margin">
                                                <li class="list-group-item">
                                                    <span class="text-muted">@lang('personal-office/products/deposits/btc.payments_number')</span>
                                                    <span class="pull-right">{{$product->payout_count}}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="text-muted">@lang('personal-office/products/deposits/btc.payout')</span>
                                                    <span class="pull-right">@lang('personal-office/products/deposits/btc.month')</span>
                                                </li>
                                                <li class="list-group-item">
                                                            <span
                                                                class="text-muted">@lang('personal-office/products/deposits/btc.percent') <span class="text-danger">*</span> </span>
                                                    <span class="pull-right">{{$product->percent}} %</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="text-muted"> @lang('personal-office/products/deposits/btc.clear') <span class="text-danger">*</span></span>
                                                    <span class="pull-right">
                                                        {{formatVMC($product->payout)}} {{$currency}}
                                                    </span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="text-muted">@lang('personal-office/products/deposits/btc.overall') <span class="text-danger">*</span></span>
                                                    <span class="pull-right">
                                                        {{formatVMC($product->payout + $product->price)}} {{$currency}}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="product-footer panel-footer">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="h4">{{$product->name}}</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="btn-group pull-right">
                                                        @include('include.payment.btc', ['service'=> 'deposit', 'product'=> $product, 'currency' => $currency])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><i class="fa fa-briefcase text-success"></i> @lang('personal-office/products/deposits/btc.my_products')</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('personal-office/products/deposits/btc.name')</th>
                                    <th>@lang('personal-office/products/deposits/btc.number_of')</th>
                                    <th>@lang('personal-office/products/deposits/btc.profit')</th>
                                    <th>@lang('personal-office/products/deposits/btc.diff')</th>
                                    <th>@lang('personal-office/products/deposits/btc.calculate')</th>
                                    <th>@lang('personal-office/products/deposits/btc.create')</th>
                                    <th>@lang('personal-office/products/deposits/btc.final')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($data as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->product['name']}}</td>
                                        <td>{{$item->number_of}} /
                                            {{$item->product['payout_count']}}</td>
                                        <td>@format_btc($item->profit)</td>
                                        <td>{{$item->calculate_at->diffInDays()}}</td>
                                        <td>
                                            <a href="javascript:;" data-toggle="tooltip"
                                               data-placement="top"
                                               data-original-title="{{$item->calculate_at->format('d/m/Y H:i:s')}}">{{$item->calculate_at->format('d/m/Y')}}</a>

                                        </td>
                                        <td>
                                            <a href="javascript:;" data-toggle="tooltip"
                                               data-placement="top"
                                               data-original-title="{{$item->calculate_at->format('d/m/Y H:i:s')}}">{{$item->calculate_at->format('d/m/Y')}}</a>
                                        </td>
                                        <td>
                                            <a href="javascript:;" data-toggle="tooltip"
                                               data-placement="top"
                                               data-original-title="{{$item->final_at->format('d/m/Y H:i:s')}}">{{$item->final_at->format('d/m/Y')}}</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">
                                            <p class="text-center text-muted no-margin-bottom">@lang('personal-office/products/deposits/btc.empty')</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="transferModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">@lang('personal-office/products/deposits/btc.output')</h4>
                    </div>
                    <div class="modal-body">
                        {{ Form::open(['route' => 'personal-office.products.deposits.transfer']) }}
                        <div class="form-group margin-sm-bottom">
                            <div class="input-group">
                                <input type="hidden" name="deposit_id" value="0">
                                <input type="number" class="form-control" name="amount_transfer" min="0.01" max="1.00"
                                       step="0.01"
                                       required autocomplete="off" placeholder="0.00">

                                <div class="input-group-btn">
                                    <button tabindex="-1" class="btn btn-primary" type="submit">@lang('personal-office/products/deposits/btc.get')</button>
                                </div>
                            </div>
                            <p class="help-block small text-muted margin-xs-vertical">@lang('personal-office/products/deposits/btc.available') <strong><span
                                        id="available_amount_transfer">0.00</span> $</strong></p>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
