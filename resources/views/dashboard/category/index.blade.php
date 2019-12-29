@extends('layouts.dashboard.app')




@section('content')
<div class="container">

@if(session('success'))

<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success</strong> {{session('success')}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>



@endif


    <div class="panner ">
				<div class="row  mb-4">
					<div class="col-md-3 ">
                  		  <h2 class="{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' ? 'float-right ' : ''}}">Categores</h2>
                  		  <small>count : {{ $category->total() }}</small>
                  		  </div>
                     <div class="to-from col-md-5 text-center">
                  		


                  		 {!! Form::open(['url' => 'dashboard/category','method' => 'get']) !!}
                  		   <div class="row">
                             <div class="form-group  col-md-8"> 
 									<input type="search" class="form-control border-0 small d-block" placeholder="Search For" aria-label="Search" aria-describedby="basic-addon2" name="search" value="{{request()->search}}">
                             </div>
                             <div class="col-md-4">

                                <button type="submit" class="btn btn-primary">
                                	<i class="fa fa-search"> </i> Search
                                </button>
                             </div>
                           </div>
                   		 {!! Form::close() !!}
                  		
                    </div>

@if(auth()->user()->hasPermissionTo('create_cat'))
                    <div class="col-md-4 text-center">
                    		  <a href="{{url('dashboard/category/create')}}" class="btn btn-primary ">
			  	                 <i class="fa fa-plus"> </i> Create New Category
			                  </a>
                    </div>
@endif
				 </div>

			<div class="jumbotron " style="background: #FFF; padding: 2rem 2rem">

	
		
  @if($category->count() == 0  )

       <h2 class="text-center">no data</h2>
   @else
			  <table class="table text-center">
					  <thead>
					    <tr>
					      <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Products</th>
					      <th scope="col">Product Count</th>
		
@if(auth()->user()->hasAnyPermission(['update_cat','delete_cat']))
             
					      <th scope="col">@Lang('site.action')</th>
@endif					      
					    </tr>
					  </thead>

					  <tbody>
					@foreach($category as $categorys)
					    <tr>
					      <td>{!! $categorys->id !!}</td>
                <td>{!! $categorys->name !!}</td>
                <td>
                  @if($categorys->products->count() > 0)
                  <a class="btn btn-info btn-sm" href="{{route('products.index',['category_id' => $categorys->id])}}">Show Products</a>
                  @endif
                </td>
					      <td>{!! $categorys->products->count() !!}</td>
	
					      <td>
			@if(auth()->user()->hasPermissionTo('update_cat'))		      	
					      	<a href="category/{{$categorys->id}}/edit" class="btn btn-info">
					      		Edit <i class="fa fa-edit"> </i>
					      	</a>
			@endif	

			@if(auth()->user()->hasPermissionTo('delete_cat'))		      	
			 	
             <a class="btn btn-danger" href="#" data-toggle="modal" data-target="#logoutModalDelete">
                  
                  Delete <i class="fa fa-trash"> </i>
                </a>




               
            @endif
					      </td>
					    </tr>
          


					@endforeach
					  </tbody>
					</table>

<div class="d-flex justify-content-center mt-5">

	{{ $category->appends(request()->query())->links() }}

	 </div>




  <div class="modal fade" id="logoutModalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Delete?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Delete" below if you are shore. Or "Cancel" to back</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

              <form method="post" action="category/{{$categorys->id}}" style="display: inline;">
              @csrf
                @method('delete')

                <button type="submit" class="btn btn-danger">Delete </button>
                  </form>

        </div>
      </div>
    </div>
  </div>




 @endif


			</div>



    </div>
			  <div class="clearfix"></div>








</div>
@endsection