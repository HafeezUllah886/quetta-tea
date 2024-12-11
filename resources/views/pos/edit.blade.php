<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>RMS - POS</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- ================== BEGIN core-css ================== -->
	<link href="{{asset('desktop-pos/css/vendor.min.css')}}" rel="stylesheet">
	<link href="{{asset('desktop-pos/css/app.min.css')}}" rel="stylesheet">
	<!-- ================== END core-css ================== -->
    <style>
        /* For modern browsers */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* For Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<body class='pace-top'>
	<!-- BEGIN #app -->
	<div id="app" class="app app-content-full-height app-without-sidebar app-without-header">
		<!-- BEGIN #content -->
		<div id="content" class="app-content p-0">
			<!-- BEGIN pos -->
			<div class="pos pos-with-menu pos-with-sidebar" id="pos">
				<div class="pos-container">
					<!-- BEGIN pos-menu -->
					<div class="pos-menu">
						<!-- BEGIN logo -->
						<div class="logo">
							<a href="index.html">
								<div class="logo-img"><i class="fa fa-bowl-rice"></i></div>
								<div class="logo-text">{{projectNameShort()}}</div>
							</a>
						</div>
						<!-- END logo -->
						<!-- BEGIN nav-container -->
						<div class="nav-container">
							<div class="h-100" data-scrollbar="true" data-skip-mobile="true">
								<ul class="nav nav-tabs">
									<li class="nav-item">
										<a class="nav-link active" href="#" data-filter="all">
											 All Categories
										</a>
									</li>
                                    @foreach ($categories as $category)
                                    <li class="nav-item">
										<a class="nav-link" href="#" data-filter="{{$category->name}}">
											{{$category->name}}
										</a>
									</li>
                                    @endforeach


								</ul>
							</div>
						</div>
						<!-- END nav-container -->
					</div>
					<!-- END pos-menu -->

					<!-- BEGIN pos-content -->
					<div class="pos-content">
						<div class="pos-content-container h-100">
							<div class="row gx-4">
                                @foreach ($items as $item)
                                <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-3 col-sm-4 pb-4" data-type="{{$item->category->name}}">
									<a href="#" class="pos-product" data-bs-toggle="modal" data-bs-target="#modalPosItem_{{$item->id}}">
										<div class="img" style="background-image: url({{ asset($item->img) }})"></div>
										<div class="info">
											<div class="title">{{$item->name}}</div>
											<div class="price">PKR
                                                @foreach ($item->sizes as $key => $size)
                                                        {{$key == 0 ? ":" : "|" }}
                                                     {{$size->price}}
                                                @endforeach
                                            </div>
										</div>
									</a>
								</div>

                                <div class="modal modal-pos fade" id="modalPosItem_{{$item->id}}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content border-0">
                                            <a href="#" data-bs-dismiss="modal" class="btn-close position-absolute top-0 end-0 m-4"></a>
                                            <div class="modal-pos-product">
                                                <div class="modal-pos-product-img">
                                                    <div class="img" style="background-image: url({{ asset($item->img) }})"></div>
                                                </div>
                                                    <div class="modal-pos-product-info">
                                                    <form id="form_{{$item->id}}" onsubmit="return addToCart(event, '{{$item->id}}')">
                                                        <div class="fs-4 fw-semibold mb-2">{{$item->name}}</div>
                                                        <div class="d-flex mb-3">
                                                            <span class="btn btn-secondary" onclick="subQty('qtymod_{{$item->id}}')"><i class="fa fa-minus"></i></span>
                                                            <input type="number" class="form-control w-50px fw-bold mx-2 text-center" min="1" id="qqtymod_{{$item->id}}" name="qty" value="1">
                                                            <span class="btn btn-secondary" onclick="addQty('qtymod_{{$item->id}}')"><i class="fa fa-plus"></i></span>
                                                        </div>
                                                        <hr class="opacity-1">
                                                        <div class="mb-2">
                                                            <input type="hidden" name="itemID" value="{{$item->id}}">
                                                            <div class="fw-bold">Size:</div>
                                                            <div class="option-list">
                                                                @foreach ($item->sizes as $key => $size)
                                                                <div class="option">
                                                                    <input type="radio" id="size{{$size->id}}" name="size{{$item->id}}" value="{{$size->id}}" class="option-input" {{$key == 0 ? "checked" : "" }}>
                                                                    <label class="option-label" for="size{{$size->id}}">
                                                                        <span class="option-text">{{$size->title}}</span>
                                                                        <span class="option-price">{{$size->price}}</span>
                                                                    </label>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        @if ($item->dealItems->isNotEmpty())
                                                            <div class="mb-2">
                                                                <div class="fw-bold">Added Items:</div>
                                                                <div class="option-list">
                                                                    @foreach ($item->dealItems as $deal)
                                                                    <div class="option">
                                                                        <label class="option-label" for="addon1">
                                                                            <span class="option-text">{{$deal->material->name}}</span>
                                                                        </label>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <hr class="opacity-1">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <a href="#" class="btn btn-default fw-semibold mb-0 d-block py-3" data-bs-dismiss="modal">Cancel</a>
                                                            </div>
                                                            <div class="col-8">
                                                                <button type="submit" class="btn btn-theme fw-semibold d-flex justify-content-center align-items-center py-3 m-0">Add to cart <i class="fa fa-plus ms-2 my-n3"></i></button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

							</div>
						</div>
					</div>
					<!-- END pos-content -->

					<!-- BEGIN pos-sidebar -->
					<div class="pos-sidebar" id="pos-sidebar">
						<div class="h-100 d-flex flex-column p-0">
							<!-- BEGIN pos-sidebar-header -->
							<div class="pos-sidebar-header">
								<div class="back-btn">
									<button type="button" data-toggle-class="pos-mobile-sidebar-toggled" data-toggle-target="#pos" class="btn">
										<i class="fa fa-chevron-left"></i>
									</button>
								</div>
								{{-- <div class="icon"><i class="fa fa-plate-wheat"></i></div>
								<div class="title">Table 01</div>
								<div class="order small">Order: <span class="fw-semibold">#0056</span></div> --}}
							</div>
							<!-- END pos-sidebar-header -->

							<!-- BEGIN pos-sidebar-nav -->
							<div class="pos-sidebar-nav small">
								<ul class="nav nav-tabs nav-fill">
									<li class="nav-item">
										<a class="nav-link active" href="#" data-bs-toggle="tab" data-bs-target="#newOrderTab">New Order (<span class="itemsQty">0</span>)</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#" data-bs-toggle="tab" data-bs-target="#orderHistoryTab">Active Orders ({{$orders->count()}})</a>
									</li>
								</ul>
							</div>
							<!-- END pos-sidebar-nav -->

							<!-- BEGIN pos-sidebar-body -->
							<div class="pos-sidebar-body tab-content" data-scrollbar="true" data-height="100%">
								<!-- BEGIN #newOrderTab -->
                                <form id="items_form" method="get">
                                    <div class="tab-pane fade h-100 show active" id="newOrderTab">
                                      @foreach ($bill->details as $key => $item)
                                      @php
                                          $qtyID = "cartqty_" . $key;
                                      @endphp
                                      <div class="pos-order" id="row_{{$key}}">
                                        <div class="pos-order-product">
                                            <div class="img" style="background-image: url({{asset($item->size->item->img)}})"></div>
                                            <div class="flex-1">
                                                <div class="h6 mb-1">{{$item->size->item->name}}</div>
                                                <div class="small">- Size: {{$item->size->name}}</div>
                                                <div class="small">- Price: {{$item->price}}</div>
                                                <div class="d-flex">
                                                    <span onclick='subQty("{{$qtyID}}")' class="btn btn-secondary btn-sm"><i class="fa fa-minus"></i></span>
                                                    <input type="number" class="form-control w-50px form-control-sm mx-2 bg-white bg-opacity-25 bg-white bg-opacity-25 text-center" name="qty[]" oninput="updateQty({{$key}})" id="q{{$qtyID}}" value="{{$item->qty}}">
                                                    <span onclick='addQty("{{$qtyID}}")' class="btn btn-secondary btn-sm"><i class="fa fa-plus"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pos-order-price d-flex flex-column">
                                            <div class="flex-1" id="amountplace_{{$key}}">{{$item->amount}}</div>
                                            <div class="text-end">
                                                <span onclick="deleteRow({{$key}})" class="btn btn-default btn-sm"><i class="fa fa-trash"></i></span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="item[]" value="{{$item->itemID}}">
                                        <input type="hidden" name="size[]" value="{{$item->sizeID}}">
                                        <input type="hidden" name="price[]" id="price_{{$key}}" value="{{$item->price}}">
                                        <input type="hidden" id="amount_{{$key}}" name="amount[]" value="{{$item->amount}}">
                                        </div>

                                      @endforeach
                                    </div>
                                </form>
								<!-- END #orderHistoryTab -->

								<!-- BEGIN #orderHistoryTab -->
								<div class="tab-pane fade h-100" id="orderHistoryTab">
									<div class="h-100">
										<div>
											@if ($orders->count() > 0)
                                            <table class="table w-100">
                                                @foreach ($orders as $order)
                                                    <tr>
                                                        <td class="text-start">
                                                            <div class="h6 mb-1">{{$order->type}}</div>
                                                            @if ($order->type == 'Dine-In')
                                                                <p class="h6 mb-1">{{$order->table->name}}</p>
                                                            @endif
                                                        </td>
                                                        <td class="text-start">
                                                            <p class="h6 mb-1">{{ $order->created_at->format('h:i:s A') }}</p>
                                                            <p class="mb-1">{{date('d-m-Y', strtotime($order->date))}}</p>

                                                        </td>
                                                        <td class="text-start">
                                                            <p class="h6 mb-1">{{ $order->waiter->name }}</p>
                                                            <p class="mb-1">Rs. {{$order->details->sum('amount')}}</p>

                                                        </td>
                                                        <td class="text-end">
                                                            <a href="{{route('bills.edit', $order->id)}}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>
                                                            <a href="{{route('bills.show', $order->id)}}" class="btn btn-theme btn-sm"><i class="fa fa-print"></i></a>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </table>

                                            @else
                                            <div class="mb-3 mt-5">
												<svg width="6em" height="6em" viewBox="0 0 16 16" class="text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
													<path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z"/>
													<path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z"/>
												</svg>
											</div>
											<h5>No active order found</h5>
                                            @endif
										</div>
									</div>
								</div>
								<!-- END #orderHistoryTab -->
							</div>
							<!-- END pos-sidebar-body -->

							<!-- BEGIN pos-sidebar-footer -->
							<div class="pos-sidebar-footer">
								<div class="d-flex align-items-center mb-2">
									<div>Total</div>
									<div class="flex-1 text-end h4 mb-0" id="totalplace">0.00</div>
                                    <input type="hidden" name="total" id="total">
								</div>
								<div class="mt-3">
                                    <form method="get" id="main_form">
                                        @csrf
									<div class="row mb-2">
										<div class="col-12">
											<div class="form-group mb-2">
												<select name="waiter" id="" class="form-control">
                                                    @foreach ($waiters as $waiter)
                                                        <option value="{{$waiter->id}}">{{$waiter->name}}</option>
                                                    @endforeach
                                                </select>
											</div>
										</div>
										<div class="col-6">
											<div class="form-group">
												<select name="type" id="" class="form-control">
                                                    <option>Dine-In</option>
                                                    <option>Delivery</option>
                                                    <option>Take Away</option>
                                                </select>
											</div>
										</div>
                                        <div class="col-6">
											<div class="form-group ">
												<select name="table" id="" required class="form-control">
                                                    @foreach ($tables as $table)
                                                        <option value="{{$table->id}}">{{$table->name}}</option>
                                                    @endforeach
                                                </select>
											</div>
										</div>
									</div>
                                </form>
									<div class="d-flex">
										<span onclick="submitForm('savep')" class="btn btn-default flex-fill d-flex align-items-center justify-content-center m-1">
											<span>
												<i class="fa fa-print fa-lg my-10px d-block"></i>
												<span class="small fw-semibold">Save & Print</span>
											</span>
										</span>
										<span onclick="submitForm('save')" class="btn btn-theme flex-fill d-flex align-items-center justify-content-center m-1">
											<span>
												<i class="fa fa-database fa-lg my-10px d-block"></i>
												<span class="small fw-semibold">Save</span>
											</span>
										</span>
									</div>
								</div>
							</div>
							<!-- END pos-sidebar-footer -->
						</div>
					</div>
					<!-- END pos-sidebar -->
				</div>
			</div>
			<!-- END pos -->
			<!-- BEGIN pos-mobile-sidebar-toggler -->
			<a href="#" class="pos-mobile-sidebar-toggler" data-toggle-class="pos-mobile-sidebar-toggled" data-toggle-target="#pos">
				<i class="fa fa-shopping-bag"></i>
				<span class="badge itemsQty">0</span>
			</a>
			<!-- END pos-mobile-sidebar-toggler -->
		</div>
		<!-- END #content -->

		<!-- BEGIN theme-panel -->
	<div class="theme-panel">
		<a href="javascript:;" data-click="theme-panel-expand" class="theme-collapse-btn"><i class="fa fa-cog"></i></a>
		<div class="theme-panel-content">
			<ul class="theme-list clearfix">
				<li><a href="javascript:;" class="bg-red" data-theme="theme-red" data-click="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Red" data-original-title="" title="">&nbsp;</a></li>
				<li><a href="javascript:;" class="bg-pink" data-theme="theme-pink" data-click="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Pink" data-original-title="" title="">&nbsp;</a></li>
				<li><a href="javascript:;" class="bg-orange" data-theme="theme-orange" data-click="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Orange" data-original-title="" title="">&nbsp;</a></li>
				<li><a href="javascript:;" class="bg-yellow" data-theme="theme-yellow" data-click="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Yellow" data-original-title="" title="">&nbsp;</a></li>
				<li><a href="javascript:;" class="bg-lime" data-theme="theme-lime" data-click="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Lime" data-original-title="" title="">&nbsp;</a></li>
				<li><a href="javascript:;" class="bg-green" data-theme="theme-green" data-click="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Green" data-original-title="" title="">&nbsp;</a></li>
				<li><a href="javascript:;" class="bg-teal" data-theme="theme-teal" data-click="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Teal" data-original-title="" title="">&nbsp;</a></li>
				<li><a href="javascript:;" class="bg-cyan" data-theme="theme-cyan" data-click="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Aqua" data-original-title="" title="">&nbsp;</a></li>
				<li class="active"><a href="javascript:;" class="bg-blue" data-theme="" data-click="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Default" data-original-title="" title="">&nbsp;</a></li>
				<li><a href="javascript:;" class="bg-purple" data-theme="theme-purple" data-click="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Purple" data-original-title="" title="">&nbsp;</a></li>
				<li><a href="javascript:;" class="bg-indigo" data-theme="theme-indigo" data-click="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Indigo" data-original-title="" title="">&nbsp;</a></li>
				<li><a href="javascript:;" class="bg-gray-600" data-theme="theme-gray-600" data-click="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Gray" data-original-title="" title="">&nbsp;</a></li>
			</ul>
			<hr class="mb-0">
			<div class="row mt-10px pt-3px">
				<div class="col-9 control-label text-body-emphasis fw-bold">
					<div>Dark Mode <span class="badge bg-theme text-theme-color ms-1 position-relative py-4px px-6px" style="top: -1px">NEW</span></div>
					<div class="lh-sm fs-13px fw-semibold">
						<small class="text-body-emphasis opacity-50">
							Adjust the appearance to reduce glare and give your eyes a break.
						</small>
					</div>
				</div>
				<div class="col-3 d-flex">
					<div class="form-check form-switch ms-auto mb-0 mt-2px">
						<input type="checkbox" class="form-check-input" name="app-theme-dark-mode" id="appThemeDarkMode" value="1">
						<label class="form-check-label" for="appThemeDarkMode">&nbsp;</label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END theme-panel -->
		<!-- BEGIN btn-scroll-top -->
		<a href="#" data-click="scroll-top" class="btn-scroll-top fade"><i class="fa fa-arrow-up"></i></a>
		<!-- END btn-scroll-top -->
	</div>
	<!-- END #app -->

	<!-- BEGIN #modalPosItem -->

	<!-- END #modalPosItem -->

	<!-- ================== BEGIN core-js ================== -->
	<script src="{{asset('desktop-pos/js/vendor.min.js')}}" type="fe1319709f44a66b3b12b39e-text/javascript"></script>
	<script src="{{asset('desktop-pos/js/app.min.js')}}" type="fe1319709f44a66b3b12b39e-text/javascript"></script>
	<!-- ================== END core-js ================== -->

	<!-- ================== BEGIN page-js ================== -->
	<script src="{{asset('desktop-pos/js/demo/pos-customer-order.demo.js')}}" type="fe1319709f44a66b3b12b39e-text/javascript"></script>
	<!-- ================== END page-js ================== -->


	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-Y3Q0VGQKY3" type="fe1319709f44a66b3b12b39e-text/javascript"></script>
	<script type="fe1319709f44a66b3b12b39e-text/javascript">
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-Y3Q0VGQKY3');
	</script>
<script src="{{asset('desktop-pos/js/rocket-loader.min.js')}}" data-cf-settings="fe1319709f44a66b3b12b39e-|49" defer></script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"8ee2d07c7c4ee17d","version":"2024.10.5","r":1,"serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"4db8c6ef997743fda032d4f73cfeff63","b":1}' crossorigin="anonymous"></script>
<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script>
     function addQty(id)
    {
        console.log(id);
        var qty = parseFloat($("#q"+id).val());
        var qty1 = qty + 1;
        $("#q"+id).val(qty1);
        updateQty(id.replace('cartqty_', ''));
    }
    function subQty(id)
    {
        console.log(id);
        var qty = parseFloat($("#q"+id).val());
        var qty1 = qty - 1;
        if(qty1 >= 1)
        {
            $("#q"+id).val(qty1);
            updateQty(id.replace('cartqty_', ''));
        }
    }
    function addToCart(e, id)
    {
        e.preventDefault();
        $("#modalPosItem_"+id).modal('hide');

        var data = $("#form_"+id).serialize();
        $.ajax({
                url: "{{ url('/bill/addtocart') }}",
                method: "GET",
                data: data,
                success: function(response) {
                    var cartHTML = "";
                    var image = "{{asset('')}}" + response.image;
                    var amount = response.qty * response.price;
                    var time = response.time;
                    var qtyID = "cartqty_" + time;
                    cartHTML += '<div class="pos-order" id="row_'+time+'">';
						cartHTML += '<div class="pos-order-product">';
							cartHTML += '<div class="img" style="background-image: url('+image+')"></div>';
							cartHTML += '<div class="flex-1">';
								cartHTML += '<div class="h6 mb-1">'+response.itemname+'</div>';
                                cartHTML += '<div class="small">- Size: '+response.sizename+'</div>';
								cartHTML += '<div class="small">- Price: '+response.price+'</div>';
								cartHTML += '<div class="d-flex">';
								    cartHTML += '<span onclick="subQty(`:qtid`)" class="btn btn-secondary btn-sm"><i class="fa fa-minus"></i></span>'.replace(':qtid', qtyID);
									cartHTML += '<input type="number" class="form-control w-50px form-control-sm mx-2 bg-white bg-opacity-25 bg-white bg-opacity-25 text-center" name="qty[]" oninput="updateQty('+time+')" id="q'+qtyID+'" value="'+response.qty+'">';
									cartHTML += '<span onclick="addQty(`:qtid`)" class="btn btn-secondary btn-sm"><i class="fa fa-plus"></i></span>'.replace(':qtid', qtyID);
								cartHTML += '</div>';
							cartHTML += '</div>';
						cartHTML += '</div>';
						cartHTML += '<div class="pos-order-price d-flex flex-column">';
							cartHTML += '<div class="flex-1" id="amountplace_'+time+'">'+amount+'</div>';
							cartHTML += '<div class="text-end">';
								cartHTML += '<span onclick="deleteRow('+time+')" class="btn btn-default btn-sm"><i class="fa fa-trash"></i></span>';
							cartHTML += '</div>';
						cartHTML += '</div>';
                        cartHTML += '<input type="hidden" name="item[]" value="'+response.itemid+'">';
                        cartHTML += '<input type="hidden" name="size[]" value="'+response.sizeid+'">';
                        cartHTML += '<input type="hidden" name="price[]" id="price_'+time+'" value="'+response.price+'">';
                        cartHTML += '<input type="hidden" id="amount_'+time+'" name="amount[]" value="'+amount+'">';
                        cartHTML += '</div>';
                    $("#newOrderTab").append(cartHTML);
                    updateTotal();
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 401) {
                        // Session expired, display error message
                        alert("Session Expired. Please login again.");
                        // Optionally, redirect to login page:
                        window.location.href = "{{ url('/') }}";
                    } else {
                        // Handle other errors as needed
                        console.error("Error:", error);
                    }
                }
            });
    }

    function updateQty(id) {
            var qty = $("#qcartqty_"+id).val();
            var amount = qty * ($("#price_" + id).val());
            $("#amount_" + id).val(amount.toFixed(2));
            $("#amountplace_" + id).html(amount.toFixed(2));
            updateTotal();
        }
        updateTotal();
        function updateTotal() {
            var total = 0;
            $("input[id^='amount_']").each(function() {
                var inputId = $(this).attr('id');
                var inputValue = $(this).val();
                total += parseFloat(inputValue);
            });
            $("#totalplace").html(total);
            $("#total").val(total);

            var count = $("[id^='row_']").length;
            $(".itemsQty").html(count);
        }

        function deleteRow(id) {
            $("#row_" + id).remove();
            updateTotal();
        }

        function submitForm(type)
        {
            var itemsForm = $("#items_form");
            var itemFields = itemsForm.find("input[id^='amount_']");

            // Check if at least one item field exists
            if (itemFields.length === 0) {
                alert("Please select at least one item.");
                return; // Prevent further processing if no item field is found
            }
            var itemsData = itemsForm.serialize();
            var mainForm = $("#main_form").serialize();
            var data = itemsData + '&' + mainForm;
            $.ajax({
                type: 'put',
                url: '{{route("bills.update",$bill->id)}}', // Replace with your script's URL
                data: data,
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(type == 'save')
                    {
                        alert("Order Updated");
                        window.location.href = "{{ url('bills/create')}}";
                    }
                    else
                    {
                        window.location.href = "{{ url('bills/')}}/"+response.id;
                    }
                },
                error: function(error) {
                    // Handle errors, e.g., display an error message
                    alert(error);
                }
            });
        }

</script>
</body>
</html>
