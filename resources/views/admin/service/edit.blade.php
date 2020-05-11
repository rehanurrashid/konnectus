@extends('admin.layouts.app')

@section('title', 'Update Approved Service')

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
                                            <h6 class="card-title">{{(isset($service)) ? 'Update' : 'Add'}} Service </h6>
                                            <div class="header-elements">
                                                <div class="list-icons">
                                                    <a class="list-icons-item" data-action="collapse"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @if(isset($service))
                                                {{ Form::model($service,['method'=>'put','route' => ['services.update',$service->id],'enctype' => 'multipart/form-data' , 'class' => 'js-form']) }}
                                            @else
                                                {{ Form::open(['route' => 'services.store' ,'enctype' => 'multipart/form-data' , 'class' => 'js-form'] ) }}
                                            @endif
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('status','Change Request Status') }}<span style="color:red;">*</span>
                                                        {{ Form::select('status', ['1' => 'Approved', '0' => 'Denied','2' => 'Pending'] ,'1' , ['class' => 'form-control select2 status', 'style'=> 'margin-bottom:10px;']) }}

                                                        {!! $errors->first('status', '<label id="status-error" class="error" for="status">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-none" id="why_deny">
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('why_deny','Why you want to disapproved/reject this request?') }}<span style="color:red;">* (Admin note)</span>
                                                        {{ Form::textarea('why_deny',old('why_deny'),array('class'=>'form-control', 'style'=> 'margin-bottom:10px;','placeholder'=>'Why you want to disapproved/reject this request?')) }}
                                                        {!! $errors->first('why_deny', '<label id="why_deny-error" class="error" for="why_deny">:message</label>') !!}

                                                        <p style="color: #B81111" id="error-reason" class="d-none ml-3">Reason to deny request is required!</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end align-items-center">
                                                <button type="submit" class="btn bg-blue ml-3">{{(isset($service)) ? 'Update' : 'Save'}} </button>
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
<script type="text/javascript">
$(document).ready(function(){

     // searchable dropdown
    $('.select2').select2();

    $("select.status").change(function(){

    var selectedType = $(this).children("option:selected").text();
        
    if(selectedType == 'Denied'){
        $('#why_deny').removeClass('d-none');
    }
    else{
        $('#why_deny').addClass('d-none');
    }

    });

    $('button[type="submit"]').click(function(e){

        e.preventDefault();

        if($('textarea[name="why_deny"]').val() == ''){
            $('#error-reason').removeClass('d-none')
        }
        else{
            $('.js-form').submit();
        }
    })
})
</script>
@endsection
