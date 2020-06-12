@extends('admin.layouts.app')

@section('title', 'Update Content')

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
                @include('admin.includes.pageheader')
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">


                <!-- Dashboard content -->
                <div class="row">
                    <div class="col-xl-12">

                        <!-- /quick stats boxes -->
                    
                    @if(isset($content))
                        {{ Form::model($content,['method'=>'put','route' => ['content_settings.update', $content->id] , 'class' => 'js-form', 'enctype' => 'multipart/form-data']) }}
                    @else
                        {{ Form::open(['route' => 'content_settings.index' , 'class' => 'js-form', 'enctype' => 'multipart/form-data']) }} 
                    @endif

                    <!-- Header Content -->
                    @include('admin.includes.content.header-content')

                    <!-- About us Content -->
                    @include('admin.includes.content.about-us-content')

                    <!-- Our Blogs Content -->
                    @include('admin.includes.content.our-blogs-content')

                    <!-- Latest Updates Content -->
                    @include('admin.includes.content.latest-updates-content')

                    <!-- App Content Content -->
                    @include('admin.includes.content.download-app-content')

                    <!-- Contact Us  Content -->
                    @include('admin.includes.content.contact-us-content')

                    <!-- Footer Content -->
                    @include('admin.includes.content.footer-content')

                    <!-- Copyrights  Content -->
                    @include('admin.includes.content.copyright-content')
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="submit"  class="btn bg-blue ml-3 w-25">Update </button>
                    </div>

                    {{ Form::close() }}

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

<!-- validation -->
<script type="text/javascript" src="{{ asset('admin/js/imageValidate.js') }}"></script>

<script src="{{ asset('js/just-validate.min.js') }}"></script>

<script type="text/javascript">
    
new window.JustValidate('.js-form', {
        rules: {
            header_logo: {
                required: true
            },
            header_bg_image:{
                required:true
            },
            header_f_image:{
                required:true
            },
            header_h:{
                required:true
            },
            header_p:{
                required:true
            },
            about_us_p:{
                required:true
            },
            about_us_h:{
                required:true
            },
            our_blogs_bg_image:{
                required:true
            },
            our_blogs_rt_image:{
                required:true
            },
            our_blogs_bl_image:{
                required:true
            },
            our_blogs_h:{
                required:true
            },
            our_blogs_p:{
                required:true
            },
            updates_h:{
                required:true
            },
            updates_p:{
                required:true
            },
            download_app_bg_image:{
                required:true
            },
            download_app_r1_image:{
                required:true
            },
            download_app_r2_image:{
                required:true
            },
            download_app_h:{
                required:true
            },
            download_app_p:{
                required:true
            },
            contact_us_h:{
                required:true
            },
            location_image:{
                required:true
            },
            location:{
                required:true
            },
            phone_image:{
                required:true
            },
            phone:{
                required:true
            },
            email_image:{
                required:true
            },
            email:{
                required:true
            },
            footer_logo:{
                required:true
            },
            footer_bg_image:{
                required:true
            },
            footer_p:{
                required:true
            },
            copyright:{
                required:true
            },
        },
    });
    $("form").submit(function (e) {

        let error  = $( this ).find( "div.js-validate-error-label" )
        $(error).parents('div.card').css({'border':'1px solid rgb(184, 17, 17)','background-color':'rgb(255, 223, 223)'})

    });

    $("input[type='text']").change( function() {
      $(this).parents('div.card').css({'border':'1px solid rgba(0,0,0,.125)','background-color':'#fff'})
    });
    $("textarea").change( function() {
      $(this).parents('div.card').css({'border':'1px solid rgba(0,0,0,.125)','background-color':'#fff'})
    });

    // // load image

    $("input[type='file']").change( function() {
      var output = $(this).parents('div.form-group').find('img.output')[0]
      output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
          URL.revokeObjectURL(output.src) // free memory
        }
        $(output).css({'width':'100%'})
    });

</script>
@endsection
