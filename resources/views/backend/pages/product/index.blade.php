       @extends('backend.layout.app')

       @section('content')

           <!--breadcrumb-->
           <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
               <div class="breadcrumb-title pe-3">Tables</div>
               <div class="ps-3">
                   <nav aria-label="breadcrumb">
                       <ol class="breadcrumb mb-0 p-0">
                           <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                           </li>
                           <li class="breadcrumb-item active" aria-current="page">Product Table</li>
                       </ol>
                   </nav>
               </div>

               @can('product-create')
               <div class="ms-auto">
                   <div class="btn-group">
                       <a href="{{ route('product.create') }}" class="btn btn-primary">Create Product</a>
                   </div>
               </div>
               @endcan

           </div>
           <!--end breadcrumb-->
           <h6 class="mb-0 text-uppercase">Product List</h6>
           <hr>
           @can('product-list')
           <div class="card">
               <div class="card-body">
                   <div class="table-responsive">
                       <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5">
                           <table id="myTable" class="display table table-striped">
                               <thead>
                                   <tr>
                                       <th>No</th>
                                       <th>Name</th>
                                       <th>Description</th>
                                       <th>Price</th>
                                       <th>Quantity</th>
                                       <th>Action</th>
                                   </tr>
                               </thead>
                               <tbody>

                                @foreach ($products as $key=>$product)


                                   <tr>



                                       <td>{{ $key+1 }}</td>
                                       <td>{{ $product->name }}</td>
                                       <td>{{ $product->description}}</td>
                                       <td>{{ $product->price }}</td>
                                       <td>{{ $product->quantity }}</td>
                                       <td class="d-flex gap-2">
                                           @can('product-edit')
                                           <a href="{{ route('products.edit',$product->id) }}" class="btn btn-primary btn-small">edit</a>
                                            @endcan

                                            @can('product-delete')
                                           <form action="{{ route('products.destroy',$product->id) }}" method="post">

                                            @csrf

                                            @method('DELETE')

                                           <button type="submit" class="btn btn-danger btn-small">delete</button>
                                           </form>

                                           @endcan

                                       </td>





                                   </tr>

                                    @endforeach

                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>
           </div>

           @endcan


           @endsection
