@extends('layouts.dashboard.app')

@section('style')

<style type="text/css">

.card-body{
	padding-left:2px; 
	padding-right:2px; 
}

.card-he2{
    padding-left:2px; 
	padding-right:0px; 
}

.card-header{
	padding-top: 1px;
    padding-bottom: 1px;
}

</style>

@endsection

@section('content')

<h2 class="text-center mb-5">Make Order</h2>

      <!-- Content Row -->

          <div class="row">

<!-- =============================================================================== -->
                    
                    <div class="col-md-6">
				              <div class="card shadow mb-4">
				                <!-- Card Header - Dropdown -->
				                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				                  <h6 class="m-0 font-weight-bold text-primary">Products</h6>
				
				                </div>
				                <!-- Card Body -->
				                <div class="card-body">
									      <div id="accordion">
									
				@foreach($category as $cate)					
											  <div class="card">
											    <div class="card-header card-he2" id="headingThree">
											      <h5 class="mb-0">
											        <button class="btn btn-link collapsed fix-foo" data-toggle="collapse" data-target="#collapse{{$cate->id}}" aria-expanded="false" aria-controls="collapseThree">
											         {{$cate->name}}
											        </button>
											      </h5>
											    </div>
                                    @if($cate->products->count() > 0)
											    <div id="collapse{{$cate->id}}" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
											      <div class="card-body">
                        

											      	<table class="table text-center">
											      		<thead>
											      			<tr>
											      				<th>Name</th>
											      				<th>Price</th>
											      				<th>Quantity in stock</th>
											      				<th>Add</th>
											      			</tr>
											      		</thead>
											      		<tbody>
							@foreach($cate->products as $product)				      			
											      			<tr>
											      				<td>{!! $product->name !!}</td>
											      				<td>{!! $product->sale_price !!}</td>
											      				<td>{!! $product->quantity !!}</td>
											      				<td>
									 <a href="" class="btn btn-success btn-sm add-order {{in_array($product->id, $order->product->pluck('id')->toArray()) ? 'disabled' : ''}}" 
									    data-name = '{!! $product->name !!}'
									    data-price='{!! $product->sale_price !!}'
                                        id = 'product-{!! $product->id !!}'
                                        data-id = '{!! $product->id !!}'

									    >
									    <i class="fa fa-plus"></i></a>
											      				</td>
											      			</tr>
							@endforeach				      			
											      		</tbody>
											      	</table>
											    	
		
											      </div>
											    </div>
											@endif      
											  </div>     

											  <!-- en of card -->


                @endforeach

									   </div>

				                </div>
				              </div>
                    </div>
<!-- =============================================================================== -->
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
				                <!-- Card Header - Dropdown -->
				             <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				                  <h6 class="m-0 font-weight-bold text-primary">Your Order</h6>
				
				             </div>
				                <!-- Card Body -->
				            <div class="card-body">
                            
                         <form action="{{route('order.update',$order->id)}}" method="POST">
                         	@csrf
                         	@method('put')
                         	<input type="hidden" name="client_id" value="{{request()->client_id}}">

                         	 	<table class="table text-center">
						      		<thead>
						      			<tr>
						      				<th>Name</th>
						      				<th>Quantity</th>
						      				<th>Price</th>
						      				<th>Delete</th>
						      			</tr>
						      		</thead>
						      		<tbody class="app-order">
                            @foreach($productOrder as $prod_Ord)            
                                        <tr class='order-{{$prod_Ord->id}}'>
							             <input type='hidden' name='products_id[]' value='{!! $prod_Ord->id !!}'>
							             
							              <td>{!! $prod_Ord->name !!}</td>
							              <td>
							                 <input type='number' name='quantity[]' min=1 value="{{$prod_Ord->pivot->quantity}}" class='form-control decressIncress'>
							              </td>
							              <td class='ProductPrice' data-price='{!! number_format($prod_Ord->sale_price,2) !!}'>
							              	{!! number_format(($prod_Ord->sale_price * $prod_Ord->pivot->quantity),2) !!}
							              </td>
							              <td>
							               <button class='btn btn-danger btn-sm removeo'  data-id='{{$prod_Ord->id}}'>
							                     <i class='fa fa-trash'></i>
							                   </button> 
							              </td>
							            </tr>
                        @endforeach

						      		</tbody>


						      	</table>
						      	<div class="form-group container row">
                                   <h5 class="col-md-8 mt-2">ToTal : <span class="TotalAmount">{{$order->TotalPrice}}</span></h5>

						      	 <input type="submit" name="order" value="Submit Order" class="btn btn-primary  col-md-4 SubmitOrder disabled" >
                         	   </div>
                         </form>   

			
				           </div>
				        </div>
                    </div>    
<!-- =============================================================================== -->

         </div> 

@endsection