@extends('admin.layouts.app')

@section('title', 'Denied Service Details')

@push('before-styles')
    <link href="{{ asset('admin/css/layout.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('after-scripts')
    <script src="{{ asset('admin/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('admin/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/tables/datatables/extensions/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('admin/js/myapp.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/js/demo_pages/datatables_extension_buttons_html5.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
    <script src="{{ asset('admin/js/demo_pages/form_multiselect.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/visualization/d3/d3_tooltip.js') }}"></script>
    <script src="{{ asset('admin/js/demo_pages/dashboard.js') }}"></script>

@endpush

@section('content')
    @include('admin.includes.navbar')
    <!-- Page content -->
    <div class="page-content" style="margin-top: 0px; ">
        <!-- Main sidebar -->
    @include('admin.includes.sidebar')
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
                @include('admin.includes.pageheader');
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">


                <!-- Dashboard content -->
                <div class="row">
                    <div class="col-xl-12">

                        <!-- /quick stats boxes -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header header-elements-inline">
                                            <h6 class="card-title">Service Details</h6>
                                            <div class="header-elements">
                                                <div class="list-icons">
                                                    <a class="list-icons-item" data-action="collapse"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                	<h4 class="float-right">User Name: </h4>
                                                </div>
                                                <div class="col">
                                                	<h4>{{$service->user->name}}</h4>
                                                </div>
                                            </div>
                                            <hr>
											<div class="row">
                                                <div class="col-md-3">
                                                	<h4 class="float-right">Category: </h4>
                                                </div>
                                                <div class="col">
                                                	<h4>{{$service->category->name}}</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                	<h4 class="float-right">Service Name </h4>
                                                </div>
                                                <div class="col">
                                                	<h4>{{$service->name}}</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                	<h4 class="float-right">Address: </h4>
                                                </div>
                                                <div class="col">
                                                	<h4>{{$service->address}}</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                	<h4 class="float-right">Phone: </h4>
                                                </div>
                                                <div class="col">
                                                	<h4>{{$service->phone}}</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                	<h4 class="float-right">Status </h4>
                                                </div>
                                                <div class="col">
                                                	<h4>
                                                        Denied
                                                		&nbsp; &nbsp; &nbsp;
                                                		<a href="{{ route('disapproved_services.edit', [$service->id]) }}" title="Change Status"><i class="icon-pencil5 mr-1 icon-1x"></i></a>
                                                	</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <!-- <div class="row">
                                                <div class="col-md-3">
                                                    <h4 class="float-right">Why you deny this request: </h4>
                                                </div>
                                                <div class="col">
                                                    <h4>{{ (!empty($service->why_deny)) ? $service->why_deny : 'No Reason Yet!'}}</h4>
                                                </div>
                                            </div> -->
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h4 class="float-right">Rating: </h4>
                                                </div>
                                                <div class="col">
                                                    <h4>{{$service->avg_rate}}</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h4 class="float-right">Total Reviews: </h4>
                                                </div>
                                                <div class="col">
                                                    <h4>{{$service->rating_count}}</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h4 class="float-right">Spoken Languages: </h4>
                                                </div>
                                                <div class="col">
                                                    <h4>{{ (!empty($place->language_code)) ? $place->language_code : 'No Languages'}}</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                	<h4 class="float-right">Tags: </h4>
                                                </div>
                                                <div class="col">
                                                	<h4>{{ (!empty($service->tags)) ? $service->tags : 'No Tags'}}</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h4 class="float-right">Image: </h4>
                                                </div>
                                                <div class="col">
                                                    @forelse($service->photos as $photo)
                                                    <img src="{{$photo->photo }}" alt="Location Image" width="40%" class="img-thumbnail">
                                                    @empty
                                                    <h4>No Images Uploaded Yet!</h4>
                                                    @endforelse
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>


                    </div>
                </div>
                <!-- /dashboard content -->
            </div>
            <!-- /content area -->


            <!-- Footer -->
            @include('admin.includes.footer')
            <!-- /footer -->

        </div>
        <!-- /main content -->

    </div>

@endsection
