@extends('admin.layouts.app')

@section('title', 'Add Place')

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
    
    <!-- tags input css -->
    <link href="{{ asset('admin/css/tagsinput.css') }}" rel="stylesheet" type="text/css">
    
    <style type="text/css">
        .bootstrap-tagsinput .badge {
            margin: 3px 6px;
            padding: 5px 8px;
            font-size:16px;
        }
        .language_code .badge-info{
            color: #fff;
    background-color: #123b40;
        }
    </style>

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
                                            <h6 class="card-title">{{(isset($place)) ? 'Update' : 'Add'}} Place </h6>
                                            <div class="header-elements">
                                                <div class="list-icons">
                                                    <a class="list-icons-item" data-action="collapse"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @if(isset($place))
                                                {{ Form::model($place,['method'=>'put','route' => ['places.update',$place->id],'enctype' => 'multipart/form-data' , 'class' => 'js-form' ]) }}
                                            @else
                                                {{ Form::open(['route' => 'places.store' ,'enctype' => 'multipart/form-data' , 'class' => 'js-form'] ) }}
                                            @endif
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('user_id','Select User') }}<span style="color:red;">*</span>
                                                        {{ Form::select('user_id', $user ,null, ['class' => 'form-control select2', 'style'=> 'margin-bottom:20px;' , 'data-validate-field' => 'user_id']) }}

                                                        {!! $errors->first('user_id', '<label id="user-id-error" class="error" for="user_id">:message</label>') !!}
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('photo','Location Images') }}
                                                        <span >(Optional)</span>

                                                        <input type="file" name="photo[]" class="form-control" style="margin-bottom:10px;" value="{{ old('photo') }}" multiple="true" data-validate-field="photo">

                                                        {!! $errors->first('photo', '<label id="photo-error" class="error" for="photo">:message</label>') !!}
                                                        <p id="error1" style="display:none; color:#B81111;">
                                                        Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF.
                                                        </p>
                                                        <p id="error2" style="display:none; color:#B81111;">
                                                        Maximum File Size Limit is 5MB.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('category_id','Select Category') }}<span style="color:red;">*</span>
                                                        @php $category[''] = 'Please Select Category'; @endphp
                                                        {{ 

                                                            Form::select('category_id', $category ,null, ['class' => 'form-control select2', 'style'=> 'margin-bottom:20px;' , 'data-validate-field' => 'category_id']) 
                                                        }}

                                                        {!! $errors->first('category_id', '<label id="category_id-error" class="error" for="category_id">:message</label>') !!}
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('tags','Tags') }}<span >(Optional)</span>
                                                        {{ Form::text('tags',old('tags'),array('class'=>'form-control', 'style'=> 'margin-bottom:10px;','placeholder'=>'Enter Tags', 'data-role' => 'tagsinput' ,'id' => 'courseTags')) }}
                                                        {!! $errors->first('tags', '<label id="tags-error" class="error" for="tags">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('name','Location Name') }}<span style="color:red;">*</span>
                                                        {{ Form::text('name',old('name'),array('class'=>'form-control', 'style'=> 'margin-bottom:10px;','placeholder'=>'Enter location name' , 'data-validate-field' => 'name')) }}
                                                        {!! $errors->first('name', '<label id="name-error" class="error" for="name">:message</label>') !!}
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('phone','Phone') }}<span style="color:red;">*</span>
                                                        {{ Form::text('phone',old('phone'),array('class'=>'form-control', 'style'=> 'margin-bottom:10px;','placeholder'=>'Enter Phone Number'  , 'data-validate-field' => 'phone')) }}
                                                        {!! $errors->first('phone', '<label id="name-error" class="error" for="name">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('address','Location Address') }}<span style="color:red;">*</span>
                                                        {{ Form::text('address',old('address'),array('class'=>'form-control', 'style'=> 'margin-bottom:10px;','placeholder'=>'Enter Place Address', 'data-validate-field' => 'address')) }}
                                                        {!! $errors->first('address', '<label id="address-error" class="error" for="address">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('longitude','Location Longitude') }}<span style="color:red;">*</span>
                                                        {{ Form::text('longitude',old('longitude'),array('class'=>'form-control', 'style'=> 'margin-bottom:10px;','placeholder'=>'Enter Longitude' , 'data-validate-field' => 'longitude')) }}
                                                        {!! $errors->first('longitude', '<label id="longitude-error" class="error" for="longitude">:message</label>') !!}
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('latitude','Location Latitude') }}<span style="color:red;">*</span>
                                                        {{ Form::text('latitude',old('latitude'),array('class'=>'form-control', 'style'=> 'margin-bottom:10px;','placeholder'=>'Enter Latitude' , 'data-validate-field' => 'latitude')) }}
                                                        {!! $errors->first('latitude', '<label id="latitude-error" class="error" for="latitude">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('from_time','Available From Time') }}<span style="color:red;">*</span>
                                                        {{ Form::text('from_time',old('from_time'),array('class'=>'form-control', 'style'=> 'margin-bottom:10px;','placeholder'=>'Enter Availabilty From Time' , 'data-validate-field' => 'from_time')) }}
                                                        {!! $errors->first('from_time', '<label id="from_time-error" class="error" for="from_time">:message</label>') !!}
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('to_time','Available To Time') }}<span style="color:red;">*</span>
                                                        {{ Form::text('to_time',old('to_time'),array('class'=>'form-control', 'style'=> 'margin-bottom:10px;','placeholder'=>'Enter Availabilty To Time' , 'data-validate-field' => 'to_time')) }}
                                                        {!! $errors->first('to_time', '<label id="to_time-error" class="error" for="to_time">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group language_code">
                                                        {{ Form::label('language_code','Language Code') }}<span >(Optional)</span>
                                                        {{ Form::text('language_code',old('language_code'),array('class'=>'form-control', 'style'=> 'margin-bottom:10px;','placeholder'=>'Enter Spoken Language Code', 'data-role' => 'tagsinput' )) }}
                                                        {!! $errors->first('language_code', '<label id="language_code-error" class="error" for="language_code">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end align-items-center">
                                                <button type="submit" class="btn bg-blue ml-3">{{(isset($faq)) ? 'Update' : 'Save'}} </button>
                                            </div>

                                            {{ Form::close() }}
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

<!-- tags input js  -->
<script src="{{ asset('admin/js/tagsinput.js') }}"></script>

<!-- validation -->
<script type="text/javascript" src="{{ asset('admin/js/imageValidate.js') }}"></script>

<script src="{{ asset('js/just-validate.min.js') }}"></script>

<script type="text/javascript">
    
        // searchable dropdown
    $('.select2').select2();

        new window.JustValidate('.js-form', {
        rules: {
            user_id: {
                required: true
            },
            category_id: {
                required: true
            },
            name: {
                required: true
            },
            photo: {
                required: true
            },
            phone: {
                required: true
            },
            address: {
                required: true
            },
            longitude: {
                required: true
            },
            latitude: {
                required: true
            },
            from_time: {
                required: true
            },
            to_time: {
                required: true
            },
        },
        messages: {
            user_id: {
                required: 'User is required',
            },
            category_id: {
                required: 'Category is required',
            },
            name: {
                required: 'Location name is required',
            },
            photo: {
                required: 'Atleast one valid image is required',
            },
            phone: {
                required: 'Phone number is required',
            },
            address: {
                required: 'Address is required',
            },
            longitude: {
                required: 'Longitude is required',
            },
            latitude: {
                required: 'Latitude is required',
            },
            from_time: {
                required: 'From which time you are available is required field',
            },
            to_time: {
                required: 'Till which time you are available is required field',
            },
        },
    });
</script>
@endsection
